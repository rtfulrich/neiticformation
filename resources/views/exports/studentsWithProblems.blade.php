<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nom </th>
            <th>Formation</th>
            <th>Etat Ecolage (en AR)</th>
            <th>Date départ du retard</th>
            <th>Repère du retard</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ ucwords($student->fname) }} {{ strtoupper($student->lname) }}</td>
            <td>
                {{ ucwords($student->formationSession->formation->title) }} | Vn° {{ $student->formationSession->session_number }}
            </td>
            <td>
                {{ $student->school_fee_paid }} sur {{ $student->formationSession->fee }} 
                ({{ $student->school_fee_paid / $student->formationSession->fee * 100 }}%)
            </td>
            <td>{{ $student->dateLateGo }} ({{ str_replace('before', 'ago', $student->lateDuration) }})</td>
            <td>{{ $student->lateStatus }}</td>
        </tr>
        @endforeach
    </tbody>
</table>