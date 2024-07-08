def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idEmpresa  like empresa.idEmpresa.

def temp-table ttempresa  no-undo serialize-name "empresa"  /* JSON SAIDA */
    like empresa.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

def VAR vidEmpresa like ttentrada.idEmpresa.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


vidEmpresa = ?.
if avail ttentrada
then do:
    vidEmpresa = ttentrada.idEmpresa.
end.

IF ttentrada.idEmpresa <> ? OR ttentrada.idEmpresa = ?
THEN DO:
    for each empresa where
        (if vidEmpresa = ?
         then true /* TODOS */
         else empresa.idEmpresa = vidEmpresa)
         no-lock.

         create ttempresa.
         BUFFER-COPY empresa TO ttempresa.
    end.
END.


find first ttempresa no-error.

if not avail ttempresa
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "empresa nao encontrada".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttempresa:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


