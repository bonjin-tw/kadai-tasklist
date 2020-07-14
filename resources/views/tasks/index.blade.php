@if(count($tasks) > 0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>ステータス</th>
                <th>タスク</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                {{-- メッセージ詳細ページへのリンク --}}
                <td>{!! link_to_route('tasks.show',$task->id,['task' => $task->id]) !!}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->content }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif