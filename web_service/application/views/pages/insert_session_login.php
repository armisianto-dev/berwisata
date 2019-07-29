<h2 id="autentikasi">Autentikasi User</h2>
<hr>
<h3 id="token">Insert Session Login</h3>
<ul>
  <li><strong>Hostname:</strong> <code><?= $hostname ?></code></li>
  <li><strong>HTTP Method:</strong> <code>POST</code></li>
  <li><strong>Path:</strong> <code>/autentikasi_user/insert_session_login</code></li>
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
      <th scope="row">session_id</th>
      <td>string(255)</td>
      <td>yes</td>
      <td>Session ID</td>
    </tr>
    <tr>
      <th scope="row">service</th>
      <td>string(100)</td>
      <td>yes</td>
      <td>Nama service yang digunakan</td>
    </tr>
    <tr>
      <th scope="row">user_id</th>
      <td>string(10)</td>
      <td>yes</td>
      <td>User ID yang login</td>
    </tr>
    <tr>
      <th scope="row">ip_address</th>
      <td>string(15)</td>
      <td>yes</td>
      <td>IP Address perangkat user (misal <code>192.168.1.1</code>)</td>
    </tr>
    <tr>
      <th scope="row">login_st</th>
      <td>string(1)</td>
      <td>yes</td>
      <td>Status login (Default : <code>1</code>)</td>
    </tr>
    <tr>
      <th scope="row">login_time</th>
      <td>datetime</td>
      <td>yes</td>
      <td>Tanggal dan Jam login (Format <code>yyyy-mm-dd hh:mm:ss</code>) </td>
    </tr>
    <tr>
      <th scope="row">cookie</th>
      <td>string(64)</td>
      <td>yes</td>
      <td>Cookie perangkat user</td>
    </tr>
    <tr>
      <th scope="row">crd</th>
      <td>date</td>
      <td>yes</td>
      <td>Tanggal login (Format <code>yyyy-mm-dd</code> )</td>
    </tr>
  </tbody>
</table>
<h5>Response Body</h5>
<figure class="highlight">
  <pre>
    <code class="language-html" data-lang="json">
      {
        "title": "Insert Login Session",
        "status": true,
        "message": "Insert login session berhasil",
        "data": {
          "status": true
        }
      }
    </code>
  </pre>
</figure>
<p>Token hasil generate akan expired dalam <code><?= $config['expiration_time'] ?></code> detik.</p>
</div>
