def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idLogin  like login.idLogin.

def temp-table ttlogin  no-undo serialize-name "login"  /* JSON SAIDA */
    like login
    FIELD nomeEmpresa like empresa.nomeEmpresa
    FIELD timeSessao like empresa.timeSessao.

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

    for each login where
        (if vidLogin = ?
         then true /* TODOS */
         else login.idLogin = vidLogin)
         no-lock.

         create ttlogin.
         ttlogin.idLogin   = login.idLogin.
         ttlogin.loginNome   = login.loginNome.
         ttlogin.statusLogin   = login.statusLogin.
         ttlogin.password   = login.password.
         ttlogin.email   = login.email.
         ttlogin.cpfCnpj   = login.cpfCnpj.
         ttlogin.pedeToken   = login.pedeToken.
         //ttlogin.nomeEmpresa   = empresa.nomeEmpresa.
         //ttlogin.timeSessao   = empresa.timeSessao.
    end.


find first ttlogin no-error.

if not avail ttlogin
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "login nao encontrada".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttlogin:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


