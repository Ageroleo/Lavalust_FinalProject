<div style="margin-top: 40px;" id="apps">
  <h3 style="color:#2e7d32; text-align:center; margin-bottom:15px;">My Applications</h3>

  {% if empty($applications) %}
      <p style="text-align:center; color:#777;">No applications submitted yet.</p>
  {% else %}
      <table border="1" cellpadding="12" cellspacing="0" 
             style="width:100%; border-collapse:collapse; background:white; margin-top:15px;">
          <thead style="background:#c5e1a5; font-weight:bold;">
              <tr>
                  <th>ID</th>
                  <th>Date Submitted</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
              {% foreach($applications as $app): %}
                  <tr>
                      <td>{{ $app['id'] }}</td>
                      <td>{{ date('F d, Y', strtotime($app['date_submitted'])) }}</td>
                      <td style="text-transform:uppercase; font-weight:bold;
                                 color:{{ $app['status'] == 'approved' ? 'green' : ($app['status'] == 'rejected' ? 'red' : 'orange') }}">
                           {{ $app['status'] }}
                      </td>
                      <td>
                          <a href="{{ BASE_URL }}/applications/view/{{ $app['id'] }}"
                             style="color:#2e7d32; font-weight:bold;">View</a>
                      </td>
                  </tr>
              {% endforeach; %}
          </tbody>
      </table>
  {% endif %}
</div>
