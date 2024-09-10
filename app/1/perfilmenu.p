def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idPerfil  like perfilmenu.idPerfil
    field idAplicativo  like perfilmenu.idAplicativo
    field idMenu  like perfilmenu.idMenu.

def temp-table ttperfilmenu  no-undo serialize-name "perfilmenu"  /* JSON SAIDA */
    like perfilmenu.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.


hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


IF ttentrada.idPerfil <> ? OR (ttentrada.idPerfil = ? and ttentrada.idAplicativo = ? and ttentrada.idMenu = ?)
THEN DO:
    for each perfilmenu where
        (if ttentrada.idPerfil = ?
         then true /* TODOS */
         else perfilmenu.idPerfil = ttentrada.idPerfil) AND
        (if ttentrada.idAplicativo = ?
         then true /* TODOS */
         else perfilmenu.idAplicativo = ttentrada.idAplicativo) AND
        (if ttentrada.idMenu = ?
         then true /* TODOS */
         else perfilmenu.idMenu = ttentrada.idMenu) 
         no-lock.
         

        create ttperfilmenu.
        BUFFER-COPY perfilmenu TO ttperfilmenu.
    end.
END.


find first ttperfilmenu no-error.

if not avail ttperfilmenu
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "PerfilMenu nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttperfilmenu:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


