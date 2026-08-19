<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"></head>
<body style="margin:0;background:#f3f5fb;font-family:Arial,Helvetica,sans-serif;color:#1e293b">
  <div style="max-width:560px;margin:0 auto;padding:24px">
    <div style="background:#4f46e5;color:#ffffff;padding:18px 22px;border-radius:12px 12px 0 0">
      <strong style="font-size:16px">Clínica Escola ULBRA</strong><br>
      <span style="font-size:13px;opacity:.9">Novo paciente cadastrado</span>
    </div>
    <div style="background:#ffffff;padding:22px;border:1px solid #e4e8f1;border-top:none;border-radius:0 0 12px 12px">
      <p>Um novo paciente realizou o cadastro no sistema:</p>
      <table style="width:100%;border-collapse:collapse;font-size:14px">
        <tr><td style="padding:6px 0;color:#64748b;width:110px">Nome</td><td style="padding:6px 0"><strong>{{ $p->name }}</strong></td></tr>
        <tr><td style="padding:6px 0;color:#64748b">E-mail</td><td style="padding:6px 0">{{ $p->email }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b">Telefone</td><td style="padding:6px 0">{{ $p->telephone }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b">Cidade</td><td style="padding:6px 0">{{ $p->city }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b">Horário</td><td style="padding:6px 0">{{ $p->time_service }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;vertical-align:top">Motivo</td><td style="padding:6px 0">{{ $p->consultation }}</td></tr>
      </table>
      <p style="color:#64748b;font-size:12px;margin-top:18px">Acesse o painel administrativo para ver os detalhes completos.</p>
    </div>
  </div>
</body>
</html>
