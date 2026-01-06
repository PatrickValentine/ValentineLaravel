<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Schools Report</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
    table { width: 100%; border-collapse: collapse; table-layout: fixed; }
    th, td {
      border: 1px solid #ddd;
      padding: 4px;
      word-wrap: break-word;
      white-space: normal;
    }
    th { background: #f5f5f5; }
  
    /* Custom column widths */
    th.org, td.org { width: 20%; }
    th.contact, td.contact { width: 20%; }
    th.address, td.address { width: 20%; }
  </style>  
</head>
<body>
  <h3>Schools Report</h3>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th class="org">Organization</th>
        <th class="contact">Contact Info</th>
        <th class="address">Address</th>
        <th>Envelopes</th>
        <th>Cards</th>
        <th>Box</th>
        {{-- <th>Dim</th> --}}
        <th>Empty Weight</th>
        <th>Full Weight</th>
        <th>Standing Order</th>
        <th>New/Update</th>
        {{-- <th>Volunteer</th>
        <th>Prefilled Link</th>
        <th>Notes from School</th>
        <th>Internal Notes</th>
        <th>Last Updated</th> --}}
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $r)
        <tr>
          <td>{{ $r->id }}</td>
          <td class="org">{{ $r->organization_name }}</td>
          <td class="contact">
            {{ $r->contact_person_name }}<br>{{ $r->how_to_address }}<br>{{ $r->email }}<br>{{ $r->phone }}
          </td>
          <td class="address">
              {{ $r->street }}, {{ $r->city }}
              @if($r->county)
                  , {{ $r->county }}
              @endif
              , {{ $r->state }} {{ $r->zip }}
          </td>
          <td>{{ $r->envelope_quantity }}</td>
          <td>{{ $r->instructions_cards }}</td>
          <td>{{ $r->box_style }}<br>{{ $r->length }}x{{ $r->width }}x{{ $r->height }}</td>
          <td>{{ $r->empty_weight }}</td>
          <td>{{ $r->full_weight }}</td>
          <td>{{ $r->standing_order ? 'Yes' : 'No' }}</td>
          <td>{{ $r->update_status ? 'Update' : 'New' }}</td>
          {{-- <td>
            @if ($r->volunteer_name)
                <div class="d-flex flex-column">
                    <div class="fw-semibold">{{ $r->volunteer_name }}</div>
                    <small class="text-muted">{{ $r->volunteer_phone }}</small>
                </div>
            @else
                <span class="text-muted">—</span>
            @endif
          </td>
          <td>{{ $r->prefilled_link }}</td>
          <td></td>
          <td></td>
          <td>
            <div class="d-flex flex-column">
                <span class="fw-semibold">{{ $r->updated_at->format('Ymd') }}</span>
                <small class="text-muted">{{ $r->updated_at->diffForHumans() }}</small>
            </div>
          </td> --}}
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
