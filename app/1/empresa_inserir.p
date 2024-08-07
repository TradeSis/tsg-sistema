def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field nomeEmpresa     like empresa.nomeEmpresa
    field host     like empresa.host
    field base     like empresa.base
    field usuario     like empresa.usuario
    field senhadb     like empresa.senhadb
    field timeSessao     like empresa.timeSessao
    field menu     like empresa.menu
    field administradora     like empresa.administradora
    field cnpj     like empresa.cnpj
    field progressdb     like empresa.progressdb
    field progressld     like empresa.progressld
    field etbcodPadrao     like empresa.etbcodPadrao.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus           as int serialize-name "status"
    field retorno   as char.


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


find empresa where empresa.nomeEmpresa = ttentrada.nomeEmpresa no-lock no-error.
if avail empresa
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "Empresa ja cadastrada".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

do on error undo:
	create empresa.
    empresa.nomeEmpresa = ttentrada.nomeEmpresa.
    empresa.host = ttentrada.host.
    empresa.base = ttentrada.base.
    empresa.usuario = ttentrada.usuario.
    empresa.senhadb = ttentrada.senhadb.
    empresa.timeSessao = ttentrada.timeSessao.
    empresa.menu = ttentrada.menu.
    empresa.administradora = ttentrada.administradora.
    empresa.cnpj = ttentrada.cnpj.
    empresa.progressdb = ttentrada.progressdb.
    empresa.progressld = ttentrada.progressld.
    empresa.etbcodPadrao = ttentrada.etbcodPadrao.

end.

create ttsaida.
ttsaida.tstatus = 200.
ttsaida.retorno = "Empresa criada com sucesso".
hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
