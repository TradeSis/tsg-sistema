def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idMenu     like tsmenu.idMenu
    field idAplicativo     like tsmenu.idAplicativo
    field idMenuSuperior     like tsmenu.idMenuSuperior
    field tabMenu     like tsmenu.tabMenu
    field srcMenu     like tsmenu.srcMenu
    field titleMenu     like tsmenu.titleMenu.

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


find tsmenu where tsmenu.idAplicativo = ttentrada.idAplicativo and tsmenu.idMenu = "" + ttentrada.idMenu + "" no-lock no-error.
if avail tsmenu
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
	create tsmenu.
	tsmenu.idMenu = ttentrada.idMenu.
	tsmenu.idAplicativo = ttentrada.idAplicativo.
	tsmenu.idMenuSuperior = ttentrada.idMenuSuperior.
    tsmenu.tabMenu = ttentrada.tabMenu. 
    tsmenu.srcMenu = ttentrada.srcMenu. 
    tsmenu.titleMenu = ttentrada.titleMenu. 

end.

create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Menu criado com sucesso".
hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
