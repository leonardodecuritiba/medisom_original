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
        <label for="contato" class="control-label">CPF <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="cpf" data-mask="999.999.999-99" required>
    </div>


</div>
<div class="form-group">
    <div class="col-sm-4">
        <label for="cep" class="control-label">CEP <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="cep" required>
    </div>

    <div class="col-sm-4">
        <label for="cidade" class="control-label">Cidade <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="cidade" required>
    </div>
    <div class="col-sm-4">
        <label for="estado" class="control-label">Estado <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="estado" required>
    </div>


</div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="bairro" class="control-label">Bairro <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="bairro" required>
    </div>
    <div class="col-sm-6">
        <label for="endereco" class="control-label">Endereço <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="endereco" required>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="phones" class="control-label">Telefones <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="phones" id="selectize-tagging" required>
    </div>
    <div class="col-sm-6">
        <label for="fax" class="control-label">FAX </label>
        <input type="text" class="form-control" name="fax">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="pagamento" class="control-label">Forma de Pagamento <span class="text-danger">*</span></label><br>
        <label class="radio-inline">
            <input name="pagamento" type="radio" value="Boleto" checked="">Boleto Bancário ($4,00 p/boleto)
        </label>
        <label class="radio-inline">
            <input name="pagamento" type="radio" value="Outro">Outro
        </label>
    </div>
    <div class="col-sm-6">
        <label for="fax" class="control-label">Prazo <span class="text-danger">*</span></label><br>
        <label class="radio-inline">
            <input name="prazo" type="radio" value="À Vista" checked="">À Vista
        </label>
        <label class="radio-inline">
            <input name="prazo" type="radio" value="À Prazo">À Prazo
        </label>
    </div>
    <div class="col-sm-6 hide" id="pagamento_outro">
        <label for="phones" class="control-label">Digite a outra forma de pagamento </label>
        <input type="text" class="form-control" name="pagamento_outro">
    </div>
    <div class="col-sm-6 hide" id="prazo_dias">
        <label for="fax" class="control-label">Digite os dias a prazo necessário </label>
        <input type="number" class="form-control" name="prazo_dias">
    </div>
</div>

<div class="form-group pf">
    <div class="col-sm-12">
        <label for="docs" class="control-label">Documentos <span class="text-danger">*</span></label>
    </div>

    <div class="col-sm-12">
        <label for="doc_rg" class="control-label">Copia do RG <span class="text-danger">*</span></label>
        <input type="file" class="form-control" name="doc_rg" required>
    </div>
    <div class="col-sm-12">
        <label for="doc_cpf" class="control-label">Copia da CPF <span class="text-danger">*</span></label>
        <input type="file" class="form-control" name="doc_cpf" required>
    </div>
</div>
<hr>
<div class="form-group">
    <div class="col-sm-12">
        <label for="correspondencia" class="control-label">Preferência para recebimento de nossas correspondências
            (extratos, avisos e etc) por: <span class="text-danger">*</span></label><br>
        <label class="radio-inline">
            <input name="correspondencia" type="radio" value="E-mail" checked="">E-mail
        </label>
        <label class="radio-inline">
            <input name="correspondencia" type="radio" value="Fax">Fax
        </label>
        <label class="radio-inline">
            <input name="correspondencia" type="radio" value="Correio">Correio
        </label>
    </div>

</div>
<hr>
<div class="form-group">
    <div class="col-sm-12">
        <label for="ref" class="control-label">Como ficou sabendo da MediSom? <span class="text-danger">*</span></label><br>
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
<hr>
<button type="submit" class="btn btn-primary">Solicitar Orçamento</button>