def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idLogin     like login.idLogin.

def temp-table ttloginempresa  no-undo serialize-name "loginempresa"  /* JSON SAIDA */
    like loginempresa
    field loginNome like login.loginNome
    field nomeEmpresa like empresa.nomeEmpresa
    field timeSessao like empresa.timeSessao
    field administradora like empresa.administradora
    field etbcodPadrao like empresa.etbcodPadrao.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.


hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


IF ttentrada.idLogin = ? 
then do:
    RUN montasaida (400,"Dados de Entrada Invalidos").
    RETURN.
end.

IF ttentrada.idLogin <> ?
THEN DO:
   
    find login where login.idLogin = ttentrada.idLogin no-lock no-error.
    if not avail login
    then do:
        RUN montasaida (401,"Usuario nao encontrado").
        RETURN.
    end.
    else do:
        for each loginempresa where loginempresa.idLogin = login.idLogin NO-LOCK:
            find empresa where empresa.idEmpresa = loginempresa.idEmpresa.

            create ttloginempresa.
            ttloginempresa.idLogin   = loginempresa.idLogin.
            ttloginempresa.idEmpresa   = loginempresa.idEmpresa.
            ttloginempresa.loginNome   = login.loginNome.
            ttloginempresa.nomeEmpresa   = empresa.nomeEmpresa.
            ttloginempresa.timeSessao   = empresa.timeSessao.
            ttloginempresa.administradora   = empresa.administradora.
            ttloginempresa.etbcodPadrao   = empresa.etbcodPadrao.
        end.
    end.
           
END.


find first ttloginempresa no-error.

if not avail ttloginempresa
then do:
    RUN montasaida (400,"Login nao possui empresas cadastradas").
    RETURN.
end.

hsaida  = TEMP-TABLE ttloginempresa:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).

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
