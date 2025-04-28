<?php
// Função para limpar os dados
function limparDados($dado) {
  $dado = trim($dado);
  $dado = stripslashes($dado);
  $dado = htmlspecialchars($dado, ENT_QUOTES, 'UTF-8');
  return $dado;
}

// Só aceita POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // Limpa os dados recebidos
  $nome = limparDados($_POST['nome'] ?? '');
  $email = limparDados($_POST['email'] ?? '');
  $assunto = limparDados($_POST['assunto'] ?? '');
  $mensagem = limparDados($_POST['mensagem'] ?? '');

  // Validação simples
  if (empty($nome) || empty($email) || empty($assunto) || empty($mensagem)) {
    echo "<script>alert('Por favor, preencha todos os campos.'); window.history.back();</script>";
    exit;
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('E-mail inválido!'); window.history.back();</script>";
    exit;
  }

  // Configurações do email
  $destinatario = "comercial.ago@yahoo.com";
  $assunto_email = "Mensagem do site: $assunto";
  $corpo_email = "
    Nome: $nome
    E-mail: $email
    Assunto: $assunto

    Mensagem:
    $mensagem
  ";

  // Cabeçalhos
  $headers = "From: $email\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

  // Tentativa de envio
  if (mail($destinatario, $assunto_email, $corpo_email, $headers)) {
    echo "<script>alert('Mensagem enviada com sucesso!'); window.location.href='index.html';</script>";
  } else {
    echo "<script>alert('Erro ao enviar mensagem. Tente novamente mais tarde.'); window.history.back();</script>";
  }

} else {
  // Se não for POST
  echo "<script>alert('Método de envio inválido.'); window.history.back();</script>";
}
?>
