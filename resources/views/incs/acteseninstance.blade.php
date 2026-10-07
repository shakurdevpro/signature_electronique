
<div class="card-datatable table-responsive">
  <table class="datatables-users table border-top">
    <thead>
      <tr>
        <th><center>Liste des documents en instance de signature</center> </th>
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
              <td>
                <button id='tous' type="button" onclick="selectAll()" class="btn btn-sm btn rounded-pill btn-icon btn-success waves-effect waves-light " title="COCHER TOUS"><i class="ti ti-check ti-xs"></i></button>
                <button id='rien' type="button" onclick="selectNone()" class="btn btn-sm btn rounded-pill btn-icon btn-danger waves-effect waves-light " title="DECOCHER TOUS"><i class="ti ti-minus ti-xs"></i></button>
                  
              </td>
              <th>N° ACTE</th>
              <th>NATURE ACTE</th>
<?php if ($info['FONCTION']=='MINISTRE'  OR $info['LOGINUSER'] == 'Z444473') { ?>  
                                        <th>TYPE CONCOURS</th>
                                        <th>EMPLOI</th>
                                        <th>ANNEE</th>
<?php } ?>
              <th>VOIR</th>
              <th>ACTION</th>
              <th hidden>POPUP</th>
            </tr>
          </thead>
         <tbody>
              @foreach ($doc as $d)
              <tr>
                  <td>
                    <input class="form-check-input selectionnerligne" name="elements[]" type="checkbox" value="{{ $d['NOM_FICHIER']}}" alt="{{ $d['GL_ACTE_ID']}}' title='{{ $d['NUMERO_ACTE']}}" /></td>
                  <td>{{$d['NUMERO_ACTE']}}</td>
                  <td>{{$d['NATURE_ACTE_LIB']}}</td>
<?php if ($info['FONCTION']=='MINISTRE'  OR $info['LOGINUSER'] == 'Z444473') { ?>  
                  <td>{{$d['TYPECONC_LIB']}}</td>
                  <td>{{$d['CONC_LIB']}}</td>
                  <td>{{$d['ANNEE']}}</td>
<?php } ?>
                  <td>
                    <a href="javascript:;" class="bi bi-journal-text modal-click-document" id="{{ ($d['NOM_FICHIER'].'.PDF') }}" name="listepresence" title="PROCES VERBAL"><i class="ti ti-eye me-2 ti-sm"></i></a>
                  </td>                                         
                  <td>
                    <a href="javascript:;" id="{{ $d['NOM_FICHIER']}}" alt="so.cisse@fonctionpublique.gouv.ci:{{ $d['NUMERO_ACTE']}}:{{$d['GL_ACTE_ID']}}" rel="noopener noreferrer" class="click-sign"><button class="btn btn-primary "><i class="ti ti-pencil me-2 ti-sm"></i> Signer</button></a>
                  </td>
                  <td hidden>   
                    <a href="javascript:;" id="popup" alt='' rel="noopener noreferrer" class="pup">POPUP</a>
                    <a href="javascript:;" id="popup-groupe" alt='' rel="noopener noreferrer" class="pup-groupe">POPUP</a>
                  </td>
              </tr>
              @endforeach
          </tbody>


        </table>
        <a href ="javascript:;"  class="btn btn-info" onclick="envoyerRequete()"  style = "background-color: #036D00 !important"><i class="ti ti-check me-2 ti-sm"></i> Signer les documents </a> 
                                       
</div>
</div>
</div>