def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idLogin   like login.idLogin
    field loginNome   like login.loginNome
    field email   like login.email
    field cpfCnpj   like login.cpfCnpj
    field pedeToken   like login.pedeToken
    field idPerfil   like login.idPerfil
    field password     like login.password
    field acao     as char.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

def var vMD5 as raw.
def var vsenhaMD5 as longchar.      

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


if not avail ttentrada
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "Dados de Entrada nao encontrados".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

find login where login.idLogin = ttentrada.idLogin no-lock no-error.
if not avail login
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "Login nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

do on error undo:
    if ttentrada.acao = "login"
    then do:
        find login where login.idLogin = ttentrada.idLogin exclusive no-error.
        login.loginNome = ttentrada.loginNome. 
        login.email = ttentrada.email. 
        login.pedeToken = ttentrada.pedeToken. 
        login.idPerfil = ttentrada.idPerfil.
        if ttentrada.cpfCnpj <> ""
        then login.cpfCnpj = ttentrada.cpfCnpj. 
    end.
    if ttentrada.acao = "senha"
    then do:
        vMD5 = md5-digest(ttentrada.password).
        vsenhaMD5 = hex-encode(vMD5).

        find login where login.idLogin = ttentrada.idLogin exclusive no-error.
        login.password = vsenhaMD5. 
    end.
    if ttentrada.acao = "token"
    then do:
        find login where login.idLogin = ttentrada.idLogin exclusive no-error.
        login.statusLogin = 0. 
        login.secret = ?. 
    end.
end.

create ttsaida.
ttsaida.tstatus = 200.
ttsaida.retorno = "Login alterada com sucesso".

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
