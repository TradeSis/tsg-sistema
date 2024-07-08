def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field login     as CHAR
    field password  as CHAR.

def temp-table ttlogin  no-undo serialize-name "login"  /* JSON SAIDA */
    like login.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

def var vMD5 as raw.
def var vsenhaMD5 as longchar.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


IF ttentrada.login = ? OR ttentrada.password = ?
then do:
    RUN montasaida (400,"Dados de Entrada Invalidos").
    RETURN.
end.

IF ttentrada.login <> ? AND ttentrada.password <> ?
THEN DO:
    find login where login.email = ttentrada.login no-lock no-error.
        if avail login
        then do:
            vMD5 = md5-digest(ttentrada.password).
            vsenhaMD5 = hex-encode(vMD5).
            ttentrada.password = vsenhaMD5.
        
            if login.password = ttentrada.password
            then do:
                find first loginaplicativo where loginaplicativo.idlogin = login.idlogin no-lock no-error.
                if not avail loginaplicativo
                then do:
                    RUN montasaida (401,"Usuario sem nivel").
                    RETURN.
                end.
                else do:
                    RUN criaLogin.
                end.
            end.
            else do:
                RUN montasaida (401,"Senha incorreta").
                RETURN.
            end.
        end.
        else do:
            find first login where login.cpfCnpj = ttentrada.login no-lock no-error.
            if not avail login
            then do:
                RUN montasaida (401,"Usuario nao encontrado").
                RETURN.
            end.
            else do:
                vMD5 = md5-digest(ttentrada.password).
                vsenhaMD5 = hex-encode(vMD5).
                ttentrada.password = vsenhaMD5.
            
                if login.password = ttentrada.password
                then do:
                    find loginaplicativo where loginaplicativo.idlogin = login.idlogin no-lock no-error.
                    if not avail loginaplicativo
                    then do:
                        RUN montasaida (401,"Usuario sem nivel").
                        RETURN.
                    end.
                    else do:
                        RUN criaLogin.
                    end.
                end.
                else do:
                    RUN montasaida (401,"Senha incorreta").
                    RETURN.
                end.
            end.
           
        end.
END.


find first ttlogin no-error.

if not avail ttlogin
then do:
    RUN montasaida (400,"login nao encontrada",?).
    RETURN.
end.

hsaida  = TEMP-TABLE ttlogin:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).

procedure criaLogin.

create ttlogin.
ttlogin.idLogin   = login.idLogin.
ttlogin.loginNome   = login.loginNome.
ttlogin.statusLogin   = login.statusLogin.
ttlogin.password   = login.password.
ttlogin.email   = login.email.
ttlogin.cpfCnpj   = login.cpfCnpj.
ttlogin.secret   = login.secret.
ttlogin.pedeToken   = login.pedeToken.

END PROCEDURE.

procedure montasaida.
    DEF INPUT PARAM tstatus AS INT.
    DEF INPUT PARAM tretorno AS CHAR.

    create ttsaida.
    ttsaida.tstatus = tstatus.
    ttsaida.retorno = tretorno.

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    put unformatted string(vlcSaida).

END PROCEDURE.
