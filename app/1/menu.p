def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idMenu  like tsmenu.idMenu
    field nomeAplicativo  like tsaplic.nomeAplicativo
    field nomeMenuSuperior  as char.

def temp-table ttmenu  no-undo serialize-name "menu"  /* JSON SAIDA */
    like tsmenu
    field nomeAplicativo  like tsaplic.nomeAplicativo.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.


hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


IF ttentrada.idMenu <> ? OR ttentrada.idMenu = ?
THEN DO:

    for each tsmenu where
        (if ttentrada.idMenu = ?
         then true /* TODOS */
         else tsmenu.idMenu = ttentrada.idMenu) 
         no-lock.
         
         find tsaplic where tsaplic.idAplicativo = tsmenu.idAplicativo no-lock.

         if ttentrada.nomeAplicativo = ? OR tsaplic.nomeAplicativo MATCHES "*" + ttentrada.nomeAplicativo + "*"
         then do:
            create ttmenu.
            BUFFER-COPY tsmenu TO ttmenu.
            ttmenu.nomeAplicativo   = tsaplic.nomeAplicativo.
            
            if tsmenu.idMenuSuperior <> 0 
            then do:
                define buffer tsmenuSup for tsmenu.
                find tsmenuSup where tsmenuSup.idMenu = tsmenu.idMenuSuperior no-lock no-error.
                if available tsmenuSup then 
                    ttmenu.nomeMenuSuperior = tsmenuSup.nomeMenu.
                else 
                    ttmenu.nomeMenuSuperior = ?.
            end.
            else 
                ttmenu.nomeMenuSuperior = ?.
         end.
    end.
END.


find first ttmenu no-error.

if not avail ttmenu
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "Menu nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttmenu:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


