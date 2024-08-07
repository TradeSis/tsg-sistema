def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idLogin  like loginestab.idLogin
    field etbcod  like loginestab.etbcod
    field idEmpresa  like loginestab.idEmpresa
    field idEmpresaLogado  like loginestab.idEmpresa.

def temp-table ttloginestab  no-undo serialize-name "loginestab"  /* JSON SAIDA */
    like loginestab
    FIELD loginNome like login.loginNome
    FIELD etbnom as char
    FIELD munic as char.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

def VAR vetbcod like ttentrada.etbcod.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


vetbcod = ?.
if avail ttentrada
then do:
    vetbcod = ttentrada.etbcod.
end.

    for each loginestab where
        loginestab.idLogin = ttentrada.idLogin and
        loginestab.idEmpresa = ttentrada.idEmpresa and
        (if vetbcod = ?
         then true /* TODOS */
         else loginestab.etbcod = vetbcod) 

         no-lock.

         create ttloginestab.
         ttloginestab.idLogin    = loginestab.idLogin.
         ttloginestab.etbcod     = loginestab.etbcod.
         ttloginestab.idEmpresa  = loginestab.idEmpresa.

         find login where login.idLogin = loginestab.idLogin no-lock.
         ttloginestab.loginNome   = login.loginNome.

         if ttentrada.idEmpresa = ttentrada.idEmpresaLogado
         then do:
            find estab where estab.etbcod = loginestab.etbcod no-lock.
            ttloginestab.etbnom   = estab.etbnom.
            ttloginestab.munic   = estab.munic.
         end.

    end.



find first ttloginestab no-error.

if not avail ttloginestab
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "login estab nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttloginestab:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).