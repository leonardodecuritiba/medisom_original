<div class="form-group">
    <div class="col-sm-6">
        <label for="name" class="control-label">Nome <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="col-sm-6">
        <label for="email" class="control-label">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" name="email" data-parsley-trigger="change" data-parsley-type="email"
               required>
    </div>
</div>
<div class="form-group pf">
    <div class="col-sm-6">
        <label for="contato" class="control-label">Pessoa de Contato </label>
        <input type="text" class="form-control" name="contato">
    </div>
    <div class="col-sm-6">
        <label for="contato" class="control-label">CPF </label>
        <input type="text" class="form-control" name="cpf" data-mask="999.999.999-99">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-4">
        <label for="cep" class="control-label">CEP </label>
        <input type="text" class="form-control" name="cep">
    </div>
    <div class="col-sm-4">
        <label for="cidade" class="control-label">Cidade </label>
        <input type="text" class="form-control" name="cidade">
    </div>
    <div class="col-sm-4">
        <label for="estado" class="control-label">Estado </label>
        <input type="text" class="form-control" name="estado">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="bairro" class="control-label">Bairro </label>
        <input type="text" class="form-control" name="bairro">
    </div>
    <div class="col-sm-6">
        <label for="endereco" class="control-label">Endereço </label>
        <input type="text" class="form-control" name="endereco">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="phones" class="control-label">Telefones <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="phones" id="phone" data-mask="(99)9999-99999" required>
    </div>
    <div class="col-sm-6">
        <label for="fax" class="control-label">FAX </label>
        <input type="text" class="form-control" name="fax">
    </div>
</div>
<div class="form-group col-xs-12" style="padding-left: 0px">
    <div class="col-sm-6">
        <label for="pagamento" class="control-label">Forma de Pagamento </label><br>
        <label class="radio-inline">
            <input name="pagamento" type="radio" value="Boleto" checked="">Boleto Bancário ($4,00 p/boleto)
        </label>
        <label class="radio-inline">
            <input name="pagamento" type="radio" value="Outro">Outro
        </label>
    </div>
    <div class="col-sm-6" style="padding-left: 21px">
        <label for="fax" class="control-label">Prazo </label><br>
        <label class="radio-inline">
            <input name="prazo" type="radio" value="À Vista" checked="">À Vista
        </label>
        <label class="radio-inline">
            <input name="prazo" type="radio" value="À Prazo">À Prazo
        </label>
    </div>
    <div class="col-sm-6 hide" id="pagamento_outro">
        <label for="phones" class="control-label">Digite a outra forma de pagamento </label>
        <input type="text" class="form-control" name="pagamento_outro" value="">
    </div>
    <div class="col-sm-6 hide" id="prazo_dias">
        <label for="fax" class="control-label">Digite os dias a prazo necessário </label>
        <input type="number" class="form-control" name="prazo_dias" value="">
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <label for="bairro" class="control-label">O que você precisa? <span class="text-danger">*</span></label>
            <textarea class="form-control" name="mensagem"
                      placeholder="Escreva aqui o que você precisa como tipo de serviço ..." required></textarea>
        </div>
    </div>
    <div class="col-sm-12">
        <hr>
    </div>
    <div class="form-group pf">
        <div class="col-sm-12">
            <label for="docs" class="control-label">Documentos </label>
        </div>
        <div class="col-sm-12">
            <label for="doc_rg" class="control-label">Copia do RG </label>
            <input type="file" class="form-control" name="doc_rg">
        </div>
        <div class="col-sm-12">
            <label for="doc_cpf" class="control-label">Copia da CPF </label>
            <input type="file" class="form-control" name="doc_cpf">
        </div>
    </div>
    <div class="col-sm-12">
        <hr>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <label for="correspondencia" class="control-label">Preferência para recebimento de nossas correspondências
                (extratos, avisos e etc) por: </label><br>
            <label class="radio-inline">
                <input name="correspondencia" type="radio" value="E-mail">E-mail
            </label>
            <label class="radio-inline">
                <input name="correspondencia" type="radio" value="Fax">Fax
            </label>
            <label class="radio-inline">
                <input name="correspondencia" type="radio" value="Correio">Correio
            </label>
        </div>
    </div>
    <div class="col-sm-12">
        <hr>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <label for="ref" class="control-label">Como ficou sabendo da MediSom? </label><br>
            <label class="radio-inline">
                <input name="ref" type="radio" value="Web-site">Web-site
            </label>
            <label class="radio-inline">
                <input name="ref" type="radio" value="Feira de Eventos">Feira de Eventos
            </label>
            <label class="radio-inline">
                <input name="ref" type="radio" value="Revista">Revista
            </label>
            <label class="radio-inline">
                <input name="ref" type="radio" value="Nossa Mala-Direta">Nossa Mala-Direta
            </label>
            <label class="radio-inline">
                <input name="ref" type="radio" value="Redes Sociais">Redes Sociais
            </label>
            <label class="radio-inline">
                <input name="ref" type="radio" value="Outro">Outro
            </label>
        </div>
    </div>
    <div class="col-sm-12">
        <hr>
    </div>