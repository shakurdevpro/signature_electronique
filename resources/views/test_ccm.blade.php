<table class="table table-bordered table-striped table-sm">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>N° Dossier</th>
            <th>Nature Acte</th>
            <th>Code Acte</th>
            <th>Numéro Acte</th>
            <th>Nom Fichier</th>
            <th>Ordre Signature</th>
            <th>État Navette</th>
            <th>Destinataire</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($doc1 as $index => $row)
            <tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $row['GL_DOSSIER_NUM'] }}</td>
    <td>{{ $row['PA_NATACTE_LIB'] ?? '-' }}</td>
    <td>{{ $row['PA_NATACTE_CODE'] ?? '-' }}</td>
    <td>{{ $row['GL_ACTE_NUM'] ?? '-' }}</td>
    <td>{{ $row['GL_ACTE_NAME'] ?? '-' }}</td>
    <td>{{ $row['GL_CCM_NAV_ORDRE'] ?? '-' }}</td>
    <td>{{ $row['GL_CCM_NAV_ETAT'] ?? '-' }}</td>
    <td>{{ $row['GL_CCM_NAV_DESTINAT'] ?? '-' }}</td>
    <td>
        
    </td>
</tr>
        @empty
            <tr>
                <td colspan="10" class="text-center text-muted">
                    Aucune donnée trouvée
                </td>
            </tr>
        @endforelse
    </tbody>
</table>





<table class="table table-bordered table-hover table-sm table-colors">
    <thead>
        <tr>
            <th>#</th>
            <th>Dossier</th>
            <th>num</th>
            <th>Ordre protocol </th>
            <th>Ordre signature</th>
            <th>Utilisateur</th>
            <th>État</th>
            <th>Date signature</th>
            <th>workflow</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($doc as $row): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($row['GL_DOSSIER_NUM']) ?></td>
                <td><?= htmlspecialchars($row['GL_ACTE_NUM']) ?></td>
                <td><?= htmlspecialchars($row['GL_CCM_NAV_ORDRE']) ?></td>
                <td><?= htmlspecialchars($row['GL_CCM_NAV_ORD_SIGN']) ?></td>
                <td><?= htmlspecialchars($row['GL_CCM_NAV_DESTINAT'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['GL_CCM_NAV_ETAT'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['GL_CCM_NAV_DATE_SIGNAT'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['GL_CCM_NAV_FLOW'] ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>





<h4 class="mt-4">📋 Détails complets des dossiers</h4>

<table class="table table-bordered table-hover table-sm">
    <thead class="table-secondary">
        <tr>
            <th>#</th>
            <th>Champ</th>
            <th>Valeur</th>
        </tr>
    </thead>
    <tbody>
        @forelse($doc1 as $index => $row)
            @foreach($row as $champ => $valeur)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $champ }}</strong></td>
                    <td>{{ $valeur ?? '-' }} </td> 
                </tr>  
            @endforeach
        @empty
            <tr>
                <td colspan="3" class="text-center text-muted">
                    Aucune donnée trouvée
                </td>
            </tr>
        @endforelse
    </tbody>
</table>









<style type="text/css">
    

    .table-colors th:nth-child(1),
.table-colors td:nth-child(1) {
    background-color: #f8d7da; /* rouge clair */
}

.table-colors th:nth-child(2),
.table-colors td:nth-child(2) {
    background-color: #d1ecf1; /* bleu clair */
}

.table-colors th:nth-child(3),
.table-colors td:nth-child(3) {
    background-color: #d4edda; /* vert clair */
}

.table-colors th:nth-child(4),
.table-colors td:nth-child(4) {
    background-color: #fff3cd; /* jaune clair */
}

.table-colors th:nth-child(5),
.table-colors td:nth-child(5) {
    background-color: #e2e3e5; /* gris clair */
}

.table-colors th:nth-child(6),
.table-colors td:nth-child(6) {
    background-color: #fde2ff; /* violet clair */
}


.table-colors th:nth-child(7),
.table-colors td:nth-child(7) {
    background-color: #F2B55A; /* violet clair */
}


.table-colors th:nth-child(8),
.table-colors td:nth-child(8) {
    background-color: pink; /* violet clair */
}

</style>