<h2 id="autentikasi">Autentikasi User</h2>
<hr>
<h3 id="token">Detail User</h3>
<ul>
  <li><strong>Hostname:</strong> <code><?= $hostname ?></code></li>
  <li><strong>HTTP Method:</strong> <code>GET</code></li>
  <li><strong>Path:</strong> <code>/autentikasi_user/detail_user_by_id/{user_id}</code></li>
  <li><strong>HTTP Headers:</strong>
    <ul>
      <li>Content-Type: <code>application/x-www-form-urlencoded</code></li>
      <li>Authorization: <code>{token}</code></li>
    </ul>
  </li>
</ul>
<h5>Response Body</h5>
<figure class="highlight">
  <pre>
    <code class="language-html" data-lang="json">
      {
        "title": "Detail User",
        "status": true,
        "message": "Detail user ditemukan",
        "data": {
          "user_id": "1712180001",
          "user_name": "user@mail.co.id",
          "user_mail": "user@mail.co.id",
          "nik": "3407161210930001",
          "user_st": "1",
          "pegawai_st": "0",
          "pegawai_id": null,
          "anggota_st": "0",
          "anggota_id": null,
          "role": "02001",
          "role_nm": "Operator ERP",
          "default_page": "dashboard\/operator",
          "nama": "John De",
          "alamat": "CANDI PURWOBINANGUN PAKEM SLEMAN YOGYAKARTA",
          "jenis_kelamin": "L",
          "telp": "08561100999",
          "user_img": "2017\/personal_images\/1712180001.jpg"
        }
      }
    </code>
  </pre>
</figure>
<p>Token hasil generate akan expired dalam <code><?= $config['expiration_time'] ?></code> detik.</p>
</div>
