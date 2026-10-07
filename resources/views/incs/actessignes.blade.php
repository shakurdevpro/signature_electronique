<div class="card-datatable table-responsive">
  <table class="datatables-users table border-top">
    <thead>
      <tr>
        <th><center>Liste des documents signés</center> </th>
      </tr>
    </thead>
  </table>
</div>

<div class="row">
  <div class="card mb-3">
      <div class="card-datatable table-responsive">
        <table class="dt-multilingual table table-striped">
          <thead>
            <tr>
              <th>N° ACTE    ddddd</th>
              <th>NATURE ACTE</th>
<?php if ($info['FONCTION']=='MINISTRE'  OR $info['LOGINUSER'] == 'Z444473') { ?>  
                                        <th>NBRE DOSSIER</th>
                                        <th>TYPE CONCOURS</th>
                                        <th>EMPLOI</th>
                                        <th>ANNEE</th>
<?php } ?>
              <th>VOIR</th>
            </tr>
          </thead>
        <tbody>
              @foreach ($docsigne as $ds)
              <tr>
                  <td>{{$ds['NUMERO_ACTE']}}</td>
                  <td>{{$ds['NATURE_ACTE_LIB']}}</td>
<?php if ($info['FONCTION']=='MINISTRE'  OR $info['LOGINUSER'] == 'Z444473') { ?>  
                  <td>{{$ds['NBR_DOSSIER']}}</td>
                  <td>{{$ds['TYPECONC_LIB']}}</td>
                  <td>{{$ds['CONC_LIB']}}</td>
                  <td>{{$ds['ANNEE']}}</td>
<?php } ?>
                  <td>
                    <a href="javascript:;" class="bi bi-journal-text modal-click-document-signe" id="{{ ($ds['NOM_FICHIER'].'.PDF') }}" name="listepresence" title="PROCES VERBAL"><i class="ti ti-eye me-2 ti-sm"></i></a>
                  </td>  
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>