<x-layout>
    <h1 > Available JObs </h1>
    <ul>
        @forelse($jobs as $job)
        <li> <a href="{{ route('jobs.show', $job->id) }}"> {{ $job->title }} - {{ $job->description }}</li>
        @empty
        <li>No jobs Available</li>
        @endforelse
    </ul>
</x-layout>