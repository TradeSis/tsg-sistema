def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idLogin  like loginaplicativo.idLogin
    field idAplicativo  like aplicativo.idAplicativo
    field buscaaplicativo  as char.

def temp-table ttaplicativo  no-undo serialize-name "aplicativo"  /* JSON SAIDA */
    like aplicativo
    FIELD idLogin like loginaplicativo.idLogin.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

def VAR vidAplicativo like ttentrada.idAplicativo.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


vidAplicativo = ?.
if avail ttentrada
then do:
    vidAplicativo = ttentrada.idAplicativo.
end.


IF ttentrada.idLogin <> ? 
THEN DO:
    for each loginaplicativo where loginaplicativo.idLogin = ttentrada.idLogin no-lock.
        find aplicativo where aplicativo.idAplicativo = loginaplicativo.idAplicativo no-lock no-error.
        if not avail aplicativo
        then do:
            create ttsaida.
            ttsaida.tstatus = 400.
            ttsaida.retorno = "aplicativo nao encontrado".

            hsaida  = temp-table ttsaida:handle.

            lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
            message string(vlcSaida).
            return.
        end.
        else do:
            create ttaplicativo.
            ttaplicativo.idAplicativo    = aplicativo.idAplicativo .
            ttaplicativo.nomeAplicativo    = aplicativo.nomeAplicativo .
            ttaplicativo.appLink   = aplicativo.appLink.
            ttaplicativo.imgAplicativo   = aplicativo.imgAplicativo.
            ttaplicativo.pathImg   = aplicativo.pathImg.
            ttaplicativo.idLogin   = loginaplicativo.idLogin.
        end.
    end.
END.

IF ttentrada.idAplicativo <> ? OR ttentrada.buscaaplicativo <> ? OR (ttentrada.idAplicativo = ? and ttentrada.buscaaplicativo = ?)
THEN DO:
    for each aplicativo where
        (if vidAplicativo = ?
         then true /* TODOS */
         else aplicativo.idAplicativo = vidAplicativo) AND
         (ttentrada.buscaaplicativo = ? OR aplicativo.nomeAplicativo MATCHES "*" + ttentrada.buscaaplicativo + "*")
         no-lock.

         create ttaplicativo.
         ttaplicativo.idAplicativo    = aplicativo.idAplicativo .
         ttaplicativo.nomeAplicativo    = aplicativo.nomeAplicativo .
         ttaplicativo.appLink   = aplicativo.appLink.
         ttaplicativo.imgAplicativo   = aplicativo.imgAplicativo.
         ttaplicativo.pathImg   = aplicativo.pathImg.
         ttaplicativo.idLogin   = ?.
    end.
END.


find first ttaplicativo no-error.

if not avail ttaplicativo
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "aplicativo nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttaplicativo:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


