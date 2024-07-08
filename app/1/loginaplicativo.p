def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idLogin  like loginaplicativo.idLogin
    field nomeAplicativo  like aplicativo.nomeAplicativo.

def temp-table ttloginaplicativo  no-undo serialize-name "loginaplicativo"  /* JSON SAIDA */
    like loginaplicativo
    FIELD loginNome like login.loginNome
    FIELD nomeAplicativo like aplicativo.nomeAplicativo.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

def VAR vidLogin like ttentrada.idLogin.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


vidLogin = ?.
if avail ttentrada
then do:
    vidLogin = ttentrada.idLogin.
end.


IF ttentrada.idLogin <> ? OR ttentrada.nomeAplicativo <> ? OR (ttentrada.idLogin = ? and ttentrada.nomeAplicativo = ?)
THEN DO:
    for each loginaplicativo where
        (if vidLogin = ?
         then true /* TODOS */
         else loginaplicativo.idLogin = vidLogin) 
         no-lock.
         
         find login where login.idLogin = loginaplicativo.idLogin no-lock.
         find aplicativo where aplicativo.idAplicativo = loginaplicativo.idAplicativo no-lock.
         
         if ttentrada.nomeAplicativo = ? OR aplicativo.nomeAplicativo MATCHES "*" + ttentrada.nomeAplicativo + "*"
         then do:
            create ttloginaplicativo.
            ttloginaplicativo.idLogin    = loginaplicativo.idLogin .
            ttloginaplicativo.idAplicativo    = loginaplicativo.idAplicativo .
            ttloginaplicativo.nivelMenu   = loginaplicativo.nivelMenu.
            ttloginaplicativo.loginNome   = login.loginNome.
            ttloginaplicativo.nomeAplicativo   = aplicativo.nomeAplicativo.
        end.
    end.
END.


find first ttloginaplicativo no-error.

if not avail ttloginaplicativo
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "login aplicativo nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttloginaplicativo:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


