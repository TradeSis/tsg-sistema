
// Programa especializado em CRAR a tabela geralfornecimento
def temp-table ttentrada no-undo serialize-name "geralfornecimento"   /* JSON ENTRADA */
    LIKE geralfornecimento.

  
def input param vAcao as char.
DEF INPUT PARAM TABLE FOR ttentrada.
def output param vmensagem as char.

vmensagem = ?.

find first ttentrada no-error.
if not avail ttentrada then do:
    vmensagem = "Dados de Entrada nao encontrados".
    return.    
end.


if vAcao = "PUT"
THEN DO:

    if ttentrada.Cnpj = ? or ttentrada.Cnpj = ""
    then do:
        vmensagem = "Dados de Entrada Invalidos".
        return.
    end.
    
    find geralpessoas where geralpessoas.cpfCnpj = ttentrada.Cnpj no-lock no-error.
    if not avail geralpessoas
    then do:
        vmensagem = "Pessoa n�o existente".
        return.    
    end.
    
    find geralprodutos where geralprodutos.idGeralProduto = ttentrada.idGeralProduto no-lock no-error.
    if not avail geralprodutos
    then do:
        vmensagem = "Produto n�o existente".
        return.  
    end.

    find geralfornecimento where geralfornecimento.Cnpj = ttentrada.Cnpj AND 
        geralfornecimento.refProduto = ttentrada.refProduto no-lock no-error.
    if avail geralfornecimento
    then do:
        vmensagem = "Fornecimento ja cadastrado".
        return.
    end.
    do on error undo:
        create geralfornecimento.
        geralfornecimento.Cnpj   = ttentrada.Cnpj.
        geralfornecimento.refProduto   = ttentrada.refProduto.
        geralfornecimento.idGeralProduto   = ttentrada.idGeralProduto.
        geralfornecimento.valorCompra   = ttentrada.valorCompra.
    end.
END.
IF vAcao = "POST" 
THEN DO:

    if ttentrada.idFornecimento = ? or ttentrada.idFornecimento = 0
    then do:
        vmensagem = "Dados de Entrada Invalidos".
        return.
    end.

    find geralfornecimento where geralfornecimento.idFornecimento = ttentrada.idFornecimento no-lock no-error.
    if not avail geralfornecimento
    then do:
        vmensagem = "Fornecimento nao cadastrado".
        return.
    end.

    do on error undo:   
        find geralfornecimento where geralfornecimento.idFornecimento = ttentrada.idFornecimento exclusive no-error.
        geralfornecimento.idGeralProduto   = ttentrada.idGeralProduto.
        geralfornecimento.valorCompra   = ttentrada.valorCompra.
    end.
    
END.
   
