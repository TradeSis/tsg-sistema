def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field nomeAplicativo     like tsaplic.nomeAplicativo
    field appLink     like tsaplic.appLink
    field imgAplicativo     like tsaplic.imgAplicativo
    field pathImg     like tsaplic.pathImg.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus           as int serialize-name "status"
    field descricaoStatus   as char.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

if not avail ttentrada
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Dados de Entrada nao encontrados".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.


find aplicativo where tsaplic.nomeAplicativo = "" + ttentrada.nomeAplicativo + "" no-lock no-error.
if avail aplicativo
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "aplicativo ja cadastrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

do on error undo:
	create tsaplic.
	tsaplic.nomeAplicativo = ttentrada.nomeAplicativo.
	tsaplic.appLink = ttentrada.appLink.
	tsaplic.imgAplicativo = ttentrada.imgAplicativo.
	tsaplic.pathImg = ttentrada.pathImg.

end.

create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "aplicativo criado com sucesso".
hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
