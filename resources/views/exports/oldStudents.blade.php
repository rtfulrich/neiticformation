<table>
    <thead>
        <tr>
            <th>n°</th>
            <th>Prénoms et Nom</th>
            <th>Formation</th>
            <th>Etat Ecolage</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>
                {{ ucwords($student->fname) }} {{ strtoupper($student->lname) }}
            </td>
            <td>
                {{ ucwords($student->formationSession->formation->title) }} | Vn° {{ $student->formationSession->session_number }}
            </td>
            <td>
                {{ round($student->school_fee_paid * 100 / $student->formationSession->fee) }} %
            </td>
        </tr>
        @endforeach
    </tbody>
</table>