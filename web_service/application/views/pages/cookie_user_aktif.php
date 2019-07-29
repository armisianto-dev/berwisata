<h2 id="autentikasi">Autentikasi User</h2>
<hr>
<h3 id="token">Cek Cookie User</h3>
<ul>
  <li><strong>Hostname:</strong> <code><?= $hostname ?></code></li>
  <li><strong>HTTP Method:</strong> <code>GET</code></li>
  <li><strong>Path:</strong> <code>/autentikasi_user/cek_cookie_user</code></li>
  <li><strong>HTTP Headers:</strong>
    <ul>
      <li>Content-Type: <code>application/x-www-form-urlencoded</code></li>
      <li>Authorization: <code>{token}</code></li>
    </ul>
  </li>
</ul>
<h5>Request Body</h5>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Field</th>
      <th scope="col">Data Type</th>
      <th scope="col">Mandatory</th>
      <th scope="col" width="37%">Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">service</th>
      <td>string(100)</td>
      <td>yes</td>
      <td>Nama service yang digunakan</td>
    </tr>
    <tr>
      <th scope="row">cookie</th>
      <td>string(64)</td>
      <td>yes</td>
      <td>Cookie perangkat user</td>
    </tr>
  </tbody>
</table>
<h5>Response Body</h5>
<figure class="highlight">
  <pre>
    <code class="language-html" data-lang="json">
      {
        "title": "Cek Cookie",
        "status": true,
        "message": "Cek cookie ditemukan",
        "data": {
          "session_id": "0jq054bcjuj9mq4mbfjmpv8315",
          "service": "erp",
          "user_id": "1712180001",
          "ip_address": "0.0.0.0",
          "user_agent": "Chrome",
          "login_st": "1",
          "login_time": "2018-05-18 13:27:19",
          "cookie": "zMQPNMQ3hbXWPNddCAJlaTYHCmk04gK2ifKlmtJNn6kvpRUnJ3wistMlAObyIZGj",
          "crd": "2018-05-18"
        }
      }
    </code>
  </pre>
</figure>
<p>Token hasil generate akan expired dalam <code><?= $config['expiration_time'] ?></code> detik.</p>
</div>
