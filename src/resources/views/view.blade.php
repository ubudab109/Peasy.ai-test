<!DOCTYPE html>
<html>
<header>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
    integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</header>

<body>

  
  <div class="container">
    <div class="row mb-5">
      <div class="col-6">Median: {{$users['median']}}</div>
      <div class="col-6">Mean: {{$users['mean']}}</div>
      <div class="col-12">TOTAL DATA : {{count($users['data'])}}</div>
    </div>
  
    <div class="row">
      <table class="table">
        <thead>
          <tr>
            <th>FULLNAME</th>
            <th>DATE OF BIRTHDAY</th>
            <th>AGE</th>
          </tr>
          @foreach ($users['data'] as $data)
              <tr>
                <td>{{$data['name']['title']}} {{$data['name']['first']}} {{$data['name']['last']}}</td>
                <td>{{date('d/m/Y',strtotime($data['dob']['date']))}}</td>
                <td>{{$data['dob']['age']}}</td>
              </tr>
          @endforeach
        </thead>
      </table>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
  </script>
</body>

</html>