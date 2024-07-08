
def input param vacao as char.
def input param ventrada as longchar.
def input param vtmp    as char.
def output param vsaida as longchar.
/* 
vws         = os-getenv("ws").
vacao       = os-getenv("acao").
ventrada    = os-getenv("entrada").
vpropath    = os-getenv("PROPATH"). /* HELIO 27/02/2024 - para versão windows */

vtmp    = os-getenv("tmp").
*/

if vtmp = ? then vtmp = "./".

/*if vpropath <> ?
then propath = vpropath. /* HELIO 27/02/2024 - para versão windows */
*/

if vacao <> ?
then do:
    if search(vacao + ".p") <> ?
    then do:
        run value(vacao + ".p") ( ventrada, vtmp ).
        vsaida = return-value.    
    end.            
    
end.


return.
