<h2 id="autentikasi">Autentikasi API</h2>
<hr>
<h3 id="token">Generate Token</h3>
<ul>
  <li><strong>Hostname:</strong> <code><?= $hostname ?></code></li>
  <li><strong>HTTP Method:</strong> <code>POST</code></li>
  <li><strong>Path:</strong> <code>/token</code></li>
  <li><strong>HTTP Headers:</strong>
    <ul>
      <li>Content-Type: <code>application/x-www-form-urlencoded</code></li>
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
      <td></td>
    </tr>
    <tr>
      <th scope="row">password</th>
      <td>string(255)</td>
      <td>yes</td>
      <td></td>
    </tr>
  </tbody>
</table>
<h5>Response Body</h5>
<figure class="highlight">
  <pre>
    <code class="language-html" data-lang="html">
      {
        <span class="color-red">"title"</span>: <span class="color-blue">"Generate Token"</span>,
        <span class="color-red">"status"</span>: <span class="color-light-blue">true</span>,
        <span class="color-red">"message"</span>: <span class="color-blue">"Token berhasil digenerate"</span>,
        <span class="color-red">"token"</span>: <span class="color-blue">"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MjYzMDI5MzIsImV4cCI6MTUyNjMwMjk5MiwidXNlcm5hbWUiOiJtdmFhZG1pbiJ9.vWu8bqqQqSMuSWOV_Yd3-F0cg4B3e-rLFrz7-PZbHOI"</span>
      }
    </code>
  </pre>
</figure>
<p>Token hasil generate akan expired dalam <code><?= $config['expiration_time'] ?></code> detik.</p>
</div>
