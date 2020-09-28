<table>
    <thead>
        <tr>
            <th>N°</th>
            <th>Nom et Prénoms</th>
            <th>Formation</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ ucwords($student->fname) }} {{ strtoupper($student->lname) }}</td>
            <td>{{ ucwords($student->formationSession->formation->title) }} | Vn° {{ $student->formationSession->session_number }}</td>
        </tr>
        @endforeach
    </tbody>
</table>