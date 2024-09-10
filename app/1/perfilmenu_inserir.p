def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idPerfil     like perfilmenu.idPerfil
    field idAplicativo     like perfilmenu.idAplicativo
    field idMenu     like perfilmenu.idMenu
    field operacoes     like perfilmenu.operacoes.

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


find perfilmenu where perfilmenu.idPerfil = "" + ttentrada.idPerfil + "" and
                      perfilmenu.idAplicativo = ttentrada.idAplicativo and perfilmenu.idMenu = "" + ttentrada.idMenu + "" no-lock no-error.
if avail perfilmenu
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Perfil Menu ja cadastrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

do on error undo:
	create perfilmenu.
	perfilmenu.idPerfil = ttentrada.idPerfil.
	perfilmenu.idAplicativo = ttentrada.idAplicativo.
	perfilmenu.idMenu = ttentrada.idMenu.
	perfilmenu.operacoes = ttentrada.operacoes.

end.

create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Perfil Menu criado com sucesso".
hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
