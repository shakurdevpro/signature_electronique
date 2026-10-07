<style>
.table-custom {
    border: 2px solid #000;
    font-size: 13px;
}

.table-custom th,
.table-custom td {
    border: 1px solid #000 !important;
    padding: 6px;
    vertical-align: middle;
}

.table-custom thead th {
    background-color: #343a40;
    color: #fff;
    text-align: center;
}

.table-custom tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

.table-custom tbody tr:hover {
    background-color: #e9ecef;
}
</style>


<div class="table-responsive">

<table class="table table-bordered table-striped table-sm table-custom">

<thead>
<tr>
<th>#</th>
<th>FC_CAND_NUM</th>
<th>PA_STRUCT_COD</th>
<th>PA_EMPLOI_CODE</th>
<th>PA_VILLE_CODE</th>
<th>PA_DIRECTION_CODE</th>
<th>PA_SERVICE_CODE</th>
<th>DATE CREA</th>
<th>USER CREA</th>
<th>FC_CAND_COMPO_NUM</th>
<th>RCAND_ES_PS</th>
<th>RCAND_ES_AFF</th>
<th>SD VALIDE</th>
<th>DATE SD</th>
<th>DIR VALIDE</th>
<th>DATE DIR</th>
<th>MIN VALIDE</th>
<th>DATE MIN</th>
<th>USER DIR</th>
<th>USER DIR SYS</th>
<th>USER SD</th>
<th>USER SD SYS</th>
<th>USER MIN</th>
<th>USER MIN SYS</th>
<th>DATE PSERV</th>
<th>EMP OPTION</th>
<th>MATRICULE CHEF</th>
<th>DATE CHEF</th>
<th>MATRICULE MODIF</th>
<th>DATE MODIF</th>
<th>PSRVICE VALIDE</th>
<th>PSRVICE MODIF</th>
<th>DATE CREATION</th>
<th>MATRICULE DRH</th>
<th>DATE DRH</th>
<th>AFF REFUSE</th>
<th>A PROMOUVOIR</th>
<th>PROMU</th>
<th>STRUCT ANCIEN</th>
<th>NAT ACTE</th>
<th>ETAT</th>
<th>VISIBLE</th>
<th>DIR USER SYS</th>
<th>SD USER SYS</th>
<th>UPLOAD WEB</th>
</tr>
</thead>

<tbody>

@forelse($doc_TMP_RCANDEMPSTRUCT as $index => $row)

<tr>

<td>{{ $index + 1 }}</td>
<td>{{ $row['FC_CAND_NUM'] }}</td>
<td>{{ $row['PA_STRUCT_COD'] ?? '-' }}</td>
<td>{{ $row['PA_EMPLOI_CODE'] ?? '-' }}</td>
<td>{{ $row['PA_VILLE_CODE'] ?? '-' }}</td>
<td>{{ $row['PA_DIRECTION_CODE'] ?? '-' }}</td>
<td>{{ $row['PA_SERVICE_CODE'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_DATECREA'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_USERCREA'] ?? '-' }}</td>

<td>{{ $row['FC_CAND_COMPO_NUM'] }}</td>
<td>{{ $row['RCAND_ES_PS'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_AFF'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_SD_VALIDE'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_DATESD'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_DIR_VALIDE'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_DATEDIR'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_MIN_VALIDE'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_DATEMIN'] ?? '-' }}</td>

<td>{{ $row['RCAND_ES_USERDIR'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_USERDIR_SYSTEME'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_USERSD'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_USERSD_SYSTEME'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_USERMIN'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_USERMIN_SYSTEME'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_DATE_DATEPSERV'] ?? '-' }}</td>
<td>{{ $row['PA_EMP_OPTION_CODE'] ?? '-' }}</td>
<td>{{ $row['MATRICULE_USERCHEF'] ?? '-' }}</td>

<td>{{ $row['DATE_USERCHEF'] ?? '-' }}</td>
<td>{{ $row['MATRICULE_USERMODIF'] ?? '-' }}</td>
<td>{{ $row['DATE_USERMODIF'] ?? '-' }}</td>
<td>{{ $row['PSRVICE_VALIDE'] ?? '-' }}</td>
<td>{{ $row['PSRVICE_MODIF_VALIDE'] ?? '-' }}</td>
<td>{{ $row['PSERV_DATECREA'] ?? '-' }}</td>
<td>{{ $row['MATRICULE_DRH'] ?? '-' }}</td>
<td>{{ $row['DATE_DRH'] ?? '-' }}</td>

<td>{{ $row['RCAND_ES_AFF_REFUSE'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_APROMOUVOIR'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_PROMU'] ?? '-' }}</td>
<td>{{ $row['PA_STRUCT_COD_ANCIEN'] ?? '-' }}</td>
<td>{{ $row['PA_NATACTE_CODE'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_ETAT'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_VISIBLE'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_DIR_USERSYS'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_SD_USERSYS'] ?? '-' }}</td>
<td>{{ $row['RCAND_ES_UPLOADWEB'] ?? '-' }}</td>

</tr>

@empty
<tr>
<td colspan="45" class="text-center text-danger">
Aucune donnée trouvée
</td>
</tr>
@endforelse

</tbody>

</table>

</div>