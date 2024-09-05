def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idPerfil  like tsperfil.idPerfil.

def temp-table ttperfil  no-undo serialize-name "perfil"  /* JSON SAIDA */
    like tsperfil.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.


hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


IF ttentrada.idPerfil <> ? OR ttentrada.idPerfil = ?
THEN DO:
    for each tsperfil where
        (if ttentrada.idPerfil = ?
         then true /* TODOS */
         else tsperfil.idPerfil = ttentrada.idPerfil) 
         no-lock.
         

        create ttperfil.
        BUFFER-COPY tsperfil TO ttperfil.
    end.
END.


find first ttperfil no-error.

if not avail ttperfil
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "Perfil nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttperfil:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


