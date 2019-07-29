<h2 id="autentikasi">Preferences</h2>
<hr>
<h3 id="token">Preferences Value</h3>
<ul>
  <li><strong>Hostname:</strong> <code><?= $hostname ?></code></li>
  <li><strong>HTTP Method:</strong> <code>GET</code></li>
  <li><strong>Path:</strong> <code>/preferences/pref_value_by_grup_name</code></li>
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
      <th scope="row">pref_group</th>
      <td>string(50)</td>
      <td>yes</td>
      <td>Preferences Group</td>
    </tr>
    <tr>
      <th scope="row">pref_nm</th>
      <td>string(50)</td>
      <td>yes</td>
      <td>Preferences Name</td>
    </tr>
  </tbody>
</table>
<h5>Response Body</h5>
<figure class="highlight">
  <pre>
    <code class="language-html" data-lang="json">
      {
        "title": "Pref Value",
        "status": true,
        "message": "Pref value ditemukan",
        "data": "images\/logo_perusahaan.png"
      }
    </code>
  </pre>
</figure>
<p>Token hasil generate akan expired dalam <code><?= $config['expiration_time'] ?></code> detik.</p>
</div>
