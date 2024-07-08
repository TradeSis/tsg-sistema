pause 0 before-hide.
def var pPorta as int.
def var pHost  as char.

def var par-param as char.
 
par-param = SESSION:PARAMETER.

pPorta = int(entry(1, par-param)).
/*if pPorta = 0 or pPorta = ?
then pPorta = 23453.
*/
{sistema/database/socket.i}

DEFINE VARIABLE hServerSocket AS HANDLE.
DEFINE VARIABLE l-Ok          AS LOGICAL.


    def var mDados  as memptr.
    def var mAux    as memptr.
    def var lOK as log.
    def var iBytes  as int.
    def var hSocket as handle.
    def var cRetorno as char.
    def var lcEnvio   as longchar.
    def var lcRetorno as longchar.
    def var CEnvio as char.
    def var mEnvio as memptr.
    def var iTamenvio as int.
    def var cMetodo as char.
    def var iTamanho  as int.
    def var ctmp as char.
    def var cStatus as char.
    def var cinicial as char.
 
CREATE SERVER-SOCKET hServerSocket.
hServerSocket:SET-CONNECT-PROCEDURE("serverSocket").
l-Ok = hServerSocket:ENABLE-CONNECTIONS( "-S " + string(pPorta)).

run logando("ENABLE-CONNECTIONS -S " + string(pPorta)).

IF NOT l-Ok THEN
 RETURN.
pause 0 before-hide.
REPEAT ON STOP UNDO, LEAVE ON QUIT UNDO, LEAVE:
    WAIT-FOR CONNECT OF hServerSocket.
    run logando("CONNECT " + string(hServerSocket)).
END.

run logando("FINALIZADO " + string(hServerSocket)).

hServerSocket:DISABLE-CONNECTIONS().
DELETE OBJECT hServerSocket.

MESSAGE "SERVER SOCKET FINALIZADO".



procedure serverSocket: 
    DEFINE INPUT PARAMETER hSocketx AS HANDLE NO-UNDO.
  

    hSocket = hSocketx.
      
    IF NOT hsocket:CONNECTED()  
    THEN DO:  
        LEAVE.  
    END.  

    run Passo1.

   
   hSocket:DISCONNECT() NO-ERROR.
    DELETE OBJECT hSocket.
      
end procedure.



procedure Passo1.

/* PASSO 1 */
    run logando("serverSocket " + string(hSocket) + " PASSO1 - WAIT ").

    WAIT-FOR READ-RESPONSE OF hSocket.  

    run lerSocketLong ( input hSocket, 
                    input 0,  
                    output cRetorno).


        cInicial =     acha&("INICIAL" ,string(cRetorno)).     
        cMetodo  =     acha&("METODO" ,string(cRetorno)).     
        iTamanho = int(acha&("TAMANHO",string(cRetorno))).
        ctmp     =     acha&("TMP" ,string(cRetorno)).     
        lcRetorno = acha&("entrada",string(cRetorno)).

    if cMetodo <> ? and
       iTamanho <> ?
    then cEnvio = "STATUS=OK".   
    else do:
        cEnvio = "STATUS=ERRO".
    end.     
   
    
    hide message no-pause.  
    run logando("serverSocket " + string(hSocket) + " POR=" + string(pPorta) + 
                " MET=" + CMetodo +
                " TAM=" + string(ITamanho) +
               /* " ENT=" + CRetorno + */
                " RET=" + CEnvio).
    
        /*
        run lerSocketLong( input hSocket, 
                           input 0, 
                           output lcRetorno).

        run logando("serverSocket " + string(hSocket) + " PASSO1 - REC Long" + "ENT=" + string(lcRetorno) ).
        */
        cInicial = replace(cInicial,"progress","socket").       
        RUN value(cInicial) 
                            (input cmetodo,
                             input lcRetorno, 
                             input ctmp,
                             output lcEnvio)
                             ) no-error.
        if error-status:error
        then do:
            lcEnvio = "ERRO".
            run logando("serverSocket " + string(hSocket) + " PASSO1 - RET Metodo=" + cmetodo + 
                    " ERRO EM " + cInicial + "-" + cMetodo + ".p"  ).
        end.
        else do:
        
            /*run logando("serverSocket " + string(hSocket) + " PASSO1 - RET Metodo=" + cmetodo + 
                    " SAI="   ).
              */
        end.
        /*
        cRetorno = string(lcRetorno).
        lcEnvio = cEnviar.
        */
        
        run escreverSocketLong (input  hSocket,
                                input  lcEnvio).
 
    run logando("serverSocket " + string(hSocket) + " PASSO1 - SAIDA").

            
end procedure.


procedure logando.
    def input param vlog as char.

    message
        today string(time,"HH:MM:SS") vlog.

end procedure.


