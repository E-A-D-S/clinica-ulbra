<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"></head>
<body style="margin:0;background:#f3f5fb;font-family:Arial,Helvetica,sans-serif;color:#1e293b">
  <div style="max-width:560px;margin:0 auto;padding:24px">
    <div style="background:#4f46e5;color:#ffffff;padding:18px 22px;border-radius:12px 12px 0 0">
      <strong style="font-size:16px">Clínica Escola ULBRA</strong><br>
      <span style="font-size:13px;opacity:.9">Cadastro recebido</span>
    </div>
    <div style="background:#ffffff;padding:22px;border:1px solid #e4e8f1;border-top:none;border-radius:0 0 12px 12px">
      <p>Olá, <strong>{{ $p->name }}</strong>!</p>
      <p>Recebemos o seu cadastro na <strong>Clínica Escola de Psicologia da ULBRA</strong>. Em breve entraremos em contato para confirmar o seu atendimento.</p>
      <p style="font-size:14px;background:#eef2ff;padding:12px 14px;border-radius:10px">
        <strong>Horário de preferência informado:</strong> {{ $p->time_service }}
      </p>
      <p style="color:#64748b;font-size:12px;margin-top:18px">Se você não realizou este cadastro, por favor ignore este e-mail. Seus dados são tratados com sigilo profissional, conforme a LGPD.</p>
    </div>
  </div>
</body>
</html>
