<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\User;
use App\Models\Group;
use App\Models\Vacation;
use App\Http\Requests\StoreVacationRequest;
use App\Http\Requests\UpdateVacationRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class VacationController extends Controller
{

    public string $error = '';

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Vacation $vacation
     * @return \Illuminate\Http\Response
     */
    public function index (Vacation $vacation)
    {
        // Данные авторизованного пользователя
        $user = User::find(Auth::id());

        $isHead = false;
        foreach ($user->groups as $group)
        {
            if ($isHead = $group->isHead())
            {
                break;
            }
        }

        $vacations = Vacation::orderBy('user_id')
            ->orderByDesc('id')->get();

        $vacationMyList = [];
        $vacationOtherList = [];

        foreach ($vacations as $vacation)
        {
            if ($vacation->user_id == Auth::id())
            {
                $vacationMyList[] = $vacation;
            }
            else
            {
                $vacationOtherList[] = $vacation;
            }
        }

        $data = [
            'user' => $user,
            'vacations' => $vacations,
            'vacationsMy' => $vacationMyList,
            'vacationsOther' => $vacationOtherList,
            'isHead' => $isHead,
        ];

        return view('vacation', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreVacationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store (StoreVacationRequest $request)
    {
        $result = Vacation::create([
            'user_id' => $request->user_id,
            'start' => Carbon::parse($request->start),
            'stop' => Carbon::parse($request->stop),
        ]);

        return response()->json([
            'success' => (boolean)$result,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateVacationRequest $request
     * @param \App\Models\Vacation $vacation
     * @return \Illuminate\Http\Response
     */
    public function update (UpdateVacationRequest $request, Vacation $vacation)
    {
        $result = false;
        $error = '';

        if ($this->checkAccess($vacation))
        {

            $updateData = [];
            if ($request->has('start'))
            {
                $updateData['start'] = Carbon::parse($request->start);
            }
            if ($request->has('stop'))
            {
                $updateData['stop'] = Carbon::parse($request->stop);
            }
            if ($request->has('fix'))
            {
                $updateData['fix'] = $request->fix;
            }

            if ($updateData)
            {
                \DB::connection()->enableQueryLog();
                $result = $vacation->update($updateData);
                $queries = \DB::getQueryLog();
                $r = 4;
//            dd(\DB::getQueryLog());;
            }
            else
            {
                $result = false;
            }
        }

        return response()->json([
            'success' => $result,
            'error' => $this->error,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Vacation $vacation
     * @return \Illuminate\Http\Response
     */
    public function destroy (Vacation $vacation)
    {
        $result = false;
        $error = '';
        if ($this->checkAccess($vacation))
        {
            $result = $vacation->delete();
        }

        return response()->json([
            'success' => $result,
            'error' => $this->error,
        ]);
    }

    /**
     * @param Vacation $vacation
     * @return bool
     */

    private function checkAccess (Vacation $vacation): bool
    {
        if ($vacation->fix == 1)
        {
            $this->error = 'Данные зафиксированы руководителем и не могут быть изменены';
            return false;
        }

        $user = User::find(Auth::id());
        $isHead = false;
        foreach ($user->groups as $group)
        {
            if ($isHead = $group->isHead())
            {
                break;
            }
        }

        if (Auth::id() != $vacation->user_id && !$isHead)
        {
            $this->error = 'У вас недостаточно прав';
            return false;
        }

        return true;
    }
}
