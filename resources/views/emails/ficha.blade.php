<h2>Ficha de Filiação Recebida - SINPOL</h2>

<h4>👤 Dados Pessoais</h4>
<p><strong>Nome completo:</strong> {{ $dados['nome'] ?? '-' }}</p>
<p><strong>CPF:</strong> {{ $dados['cpf'] ?? '-' }}</p>
<p><strong>Identidade:</strong> {{ $dados['identidade'] ?? '-' }}</p>
<p><strong>Órgão Emissor:</strong> {{ $dados['orgao_emissor'] ?? '-' }}</p>
<p><strong>Sexo:</strong> {{ $dados['sexo'] ?? '-' }}</p>
<p><strong>Data de nascimento:</strong> {{ \Carbon\Carbon::parse($dados['data_nascimento'])->format('d/m/Y') ?? '-' }}</p>
<p><strong>Estado Civil:</strong> {{ $dados['estado_civil'] ?? '-' }}</p>
<p><strong>Telefone:</strong> {{ $dados['telefone'] ?? '-' }}</p>
<p><strong>Email:</strong> {{ $dados['email'] ?? '-' }}</p>
<p><strong>Nacionalidade:</strong> {{ $dados['nacionalidade'] ?? '-' }}</p>
<p><strong>Naturalidade:</strong> {{ $dados['naturalidade'] ?? '-' }}</p>
<p><strong>Filiação:</strong> {{ $dados['filiacao'] ?? '-' }}</p>

<hr>

<h4>🏠 Endereço</h4>
<p><strong>CEP:</strong> {{ $dados['cep'] ?? '-' }}</p>
<p><strong>Endereço:</strong> {{ $dados['endereco'] ?? '-' }}</p>
<p><strong>Bairro:</strong> {{ $dados['bairro'] ?? '-' }}</p>
<p><strong>Município:</strong> {{ $dados['municipio'] ?? '-' }}</p>
<p><strong>Estado:</strong> {{ $dados['estado'] ?? '-' }}</p>

<hr>

<h4>💼 Dados Funcionais</h4>
<p><strong>Cargo:</strong> {{ $dados['cargo'] ?? '-' }}</p>
<p><strong>Data de admissão:</strong> {{ \Carbon\Carbon::parse($dados['data_admissao'])->format('d/m/Y') ?? '-' }}</p>
<p><strong>Lotação:</strong> {{ $dados['lotacao'] ?? '-' }}</p>
<p><strong>Matrícula:</strong> {{ $dados['matricula'] ?? '-' }}</p>
<p><strong>ID Funcional:</strong> {{ $dados['id_funcional'] ?? '-' }}</p>
<p><strong>Aposentado:</strong> {{ $dados['aposentado'] ?? '-' }}</p>
<p><strong>Data de aposentadoria:</strong> {{ \Carbon\Carbon::parse($dados['data_aposentadoria'])->format('d/m/Y') ?? '-' }}</p>

@if (!empty($dados['beneficiarios']) && is_array($dados['beneficiarios']))
    <p><strong>Beneficiários:</strong> {{ implode(', ', $dados['beneficiarios']) }}</p>
@else
    <p><strong>Beneficiários:</strong> -</p>
@endif

<hr>
<h4>📄 Autorização de desconto</h4>
<p><strong>Autorizou desconto em folha?</strong>
    {{ isset($dados['autorizacao_desconto']) && $dados['autorizacao_desconto'] === 'on' ? 'Sim' : 'Não' }}
</p>

<hr>

<p><strong>📎 Arquivos anexos:</strong> Enviados no corpo do e-mail.</p>

<p>—</p>
<p style="font-style: italic;">Este e-mail foi gerado automaticamente pelo site do sindicato.</p>
