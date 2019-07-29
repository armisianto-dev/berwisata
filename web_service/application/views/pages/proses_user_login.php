<h2 id="autentikasi">Autentikasi User</h2>
<hr>
<h3 id="token">Proses User Login</h3>
<ul>
  <li><strong>Hostname:</strong> <code><?= $hostname ?></code></li>
  <li><strong>HTTP Method:</strong> <code>POST</code></li>
  <li><strong>Path:</strong> <code>/autentikasi_user/proses_user_login</code></li>
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
      <th scope="row">username</th>
      <td>string(255)</td>
      <td>yes</td>
      <td>Username/Email yang terdaftar</td>
    </tr>
    <tr>
      <th scope="row">password</th>
      <td>string(255)</td>
      <td>yes</td>
      <td>Password User</td>
    </tr>
    <tr>
      <th scope="row">portal_id</th>
      <td>numeric(2)</td>
      <td>yes</td>
      <td>ID Portal</td>
    </tr>
  </tbody>
</table>
<h5>Response Body</h5>
<figure class="highlight">
  <pre>
    <code class="language-html" data-lang="json">
      {
        "title": "User login",
        "status": true,
        "message": "User login berhasil",
        "data": {
          "status": true
        }
      }
    </code>
  </pre>
</figure>
<p>Token hasil generate akan expired dalam <code><?= $config['expiration_time'] ?></code> detik.</p>
</div>
