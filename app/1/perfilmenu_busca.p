def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idPerfil  like perfilmenu.idPerfil.


/*nova estrutura*/
def temp-table ttperfil  no-undo serialize-name "perfil"  
    like tsperfil
    field id as char serialize-hidden.

def temp-table ttaplicativo  no-undo serialize-name "aplicativos" 
    like tsaplic
    field idpai as char serialize-hidden.

def temp-table ttmenu  no-undo serialize-name "menus"  
    like tsmenu.

def temp-table ttperfilmenu  no-undo serialize-name "perfilmenu"  
    like perfilmenu.

DEF DATASET dsPerfilMenu  SERIALIZE-NAME "conteudoPerfil" 
    FOR ttperfil, ttaplicativo, ttmenu, ttperfilmenu
    DATA-RELATION for1 FOR ttperfil, ttaplicativo    RELATION-FIELDS(ttperfil.id,ttaplicativo.idpai) NESTED
    DATA-RELATION for2 FOR ttaplicativo, ttmenu     RELATION-FIELDS(ttaplicativo.idAplicativo,ttmenu.idAplicativo) NESTED
    DATA-RELATION for3 FOR ttmenu, ttperfilmenu      RELATION-FIELDS(ttmenu.idMenu,ttperfilmenu.idMenu) NESTED.
 

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.


hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

/*perfil*/
find tsperfil where tsperfil.idPerfil = ttentrada.idPerfil no-lock no-error.
if  avail tsperfil
then do:

    
    create ttperfil.
    ttperfil.idPerfil = tsperfil.idPerfil.
    ttperfil.aplicativos = tsperfil.aplicativos.

    /*aplicativo*/
    for each tsaplic where index(tsperfil.aplicativos, tsaplic.nomeAplicativo) > 0 no-lock.
        create ttaplicativo.
        ttaplicativo.idAplicativo = tsaplic.idAplicativo.
        ttaplicativo.nomeAplicativo = tsaplic.nomeAplicativo.
        ttaplicativo.appLink = tsaplic.appLink.

        /*menu*/
        for each tsmenu where tsmenu.idAplicativo = tsaplic.idAplicativo no-lock.
            create ttmenu.
            ttmenu.idMenu = tsmenu.idMenu.
            ttmenu.idAplicativo = tsmenu.idAplicativo.
            ttmenu.idMenuSuperior = tsmenu.idMenuSuperior.
            ttmenu.menuOp = tsmenu.menuOp.
            ttmenu.nomeMenu = tsmenu.nomeMenu.
    
            /*perfilmenu*/
            find perfilmenu where perfilmenu.idPerfil = tsperfil.idPerfil and
                                  perfilmenu.idAplicativo = tsaplic.idAplicativo and
                                  perfilmenu.idMenu = tsmenu.idMenu 
                                  no-lock no-error.
            if avail perfilmenu
            then do:
                create ttperfilmenu.
                ttperfilmenu.idPerfil = perfilmenu.idPerfil.
                ttperfilmenu.idAplicativo = perfilmenu.idAplicativo.
                ttperfilmenu.idMenu = perfilmenu.idMenu.
                ttperfilmenu.operacoes = perfilmenu.operacoes.
        
            end.
        end.
    end.
end.




find first ttperfil no-error.

if not avail ttperfil
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "PerfilMenu nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = dataset dsPerfilMenu:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


