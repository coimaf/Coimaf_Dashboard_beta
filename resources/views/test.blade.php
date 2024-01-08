<x-Layouts.layout>
    <h1 class="text-center my-5">TEST</h1>
    
    <ul>
        @foreach ($users as $user)
            <li>{{$user->name}}</li>
            <li>{{$user->email}}</li>

            {{-- Utilizza l'accessore getGroupArrayAttribute --}}
            @if (is_string($user->groups))
            @foreach (explode(' - ', $user->groups) as $group)
                <li>{{$group}}</li>
            @endforeach
        @endif
        <br>
        <br>
        @endforeach
    </ul>
</x-Layouts.layout>
