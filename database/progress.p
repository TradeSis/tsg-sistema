
/*VERSAO 2 23062021*/

def var vacao as char.
def var vws as char.
def var ventrada as longchar.
def var vtmp    as char.
def var vpropath as char.
def var vempresa as int.
vws         = os-getenv("ws").
vacao       = os-getenv("acao").
ventrada    = os-getenv("entrada").
vpropath    = os-getenv("PROPATH"). /* HELIO 27/02/2024 - para versão windows */
vempresa    = int(os-getenv("empresa")).
vtmp    = os-getenv("tmp").
if vtmp = ? then vtmp = "./".

if vpropath <> ?
then propath = vpropath. /* HELIO 27/02/2024 - para versão windows */
if vempresa <> 0 and vempresa <> ?
then do:
    find empresa where empresa.idEmpresa =  vempresa no-lock no-error.
    if avail empresa
    then do:
        if empresa.progressld <> ? and empresa.progressld <> ""
        then do:
            if NOT CONNECTED(empresa.progressld) then do:
                CONNECT VALUE("-db " + empresa.progressdb) no-error.
                if NOT CONNECTED(empresa.progressld) then do:
                    message "ERRO AO CONECTAR BANCO".
                    return.
                end.
            end.
        end.
    end.
    else do:
        message "EMPRESA " + string(vempresa) + " NAO CADASTRADA".
        return.
    end.
end.


if vacao <> ?
then do:
    if search(vacao + ".p") <> ?
    then  run value(vacao + ".p") ( ventrada, vtmp).
end.


return.
