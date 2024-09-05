def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field nomePerfil     like tsperfil.nomePerfil
    field aplicativos     like tsperfil.aplicativos
    field menus     like tsperfil.menus
    field pEXC     like tsperfil.pEXC
    field pALT     like tsperfil.pALT
    field pINS     like tsperfil.pINS.

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


find tsperfil where tsperfil.nomePerfil = "" + ttentrada.nomePerfil + "" no-lock no-error.
if avail tsperfil
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Menu ja cadastrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

do on error undo:
	create tsperfil.
	tsperfil.nomePerfil = ttentrada.nomePerfil.
	tsperfil.aplicativos = ttentrada.aplicativos.
	tsperfil.menus = ttentrada.menus.
	tsperfil.pEXC = ttentrada.pEXC.
	tsperfil.pALT = ttentrada.pALT.
	tsperfil.pINS = ttentrada.pINS.

end.

create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Menu criado com sucesso".
hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
