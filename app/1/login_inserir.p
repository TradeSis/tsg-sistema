def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field loginNome     like login.loginNome
    field email     like login.email
    field idEmpresa     like empresa.idEmpresa
    field cpfCnpj     like login.cpfCnpj
    field pedeToken     like login.pedeToken
    field password     like login.password.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus           as int serialize-name "status"
    field retorno   as char.

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

if ttentrada.cpfCnpj = ""
then do:
    ttentrada.cpfCnpj = ?.
end.


find login where login.email = ttentrada.email  no-lock no-error.
if avail login
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "Email ja possui cadastro".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

if ttentrada.cpfCnpj <> ?
then do :
    find login where login.cpfCnpj = ttentrada.cpfCnpj  no-lock no-error.
    if avail login
    then do:
        create ttsaida.
        ttsaida.tstatus = 400.
        ttsaida.retorno = "CPF ja possui cadastro".

        hsaida  = temp-table ttsaida:handle.

        lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
        message string(vlcSaida).
        return.
    end.
end.

do on error undo:
    vMD5 = md5-digest(ttentrada.password).
    vsenhaMD5 = hex-encode(vMD5).

	create login.
    login.loginNome = ttentrada.loginNome.
    login.email = ttentrada.email.
    login.cpfCnpj = ttentrada.cpfCnpj.
    login.pedeToken = ttentrada.pedeToken.
    login.password = vsenhaMD5.
    login.statusLogin = 0.

    create loginempresa.
    loginempresa.idLogin = login.idLogin.
    loginempresa.idEmpresa = ttentrada.idEmpresa.


end.

create ttsaida.
ttsaida.tstatus = 200.
ttsaida.retorno = "Login criado com sucesso".
hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
