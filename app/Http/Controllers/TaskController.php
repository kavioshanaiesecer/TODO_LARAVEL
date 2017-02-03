<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;





class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('id','desc')->paginate(5);

        return view('tasks.index')->with('storedTasks',$tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'newTaskname' => 'required|min:5|max:255',
            ]);

        $task = new Task;
        $task->name=$request->newTaskname;
        $task->save();
        session()->flash('success','New Task has been added!!!');
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('tasks.edit')->with('taskUnderEdit',$task);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
           'updatedTask'=>'required|min:5|max:255'
        ]);
        $task = Task::find($id);
        $task->name = $request->updatedTask;
        $task->save();
        session()->flash('success','Task #'.$id.' has been successfully updated!');
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $task = Task::find($id);
        $task->delete();
        session()->flash('success','Task #'.$id.' has been successfully deleted!!');
        return redirect()->route('tasks.index');
    }
}
