<?php 

namespace App\Repositories\Admin\Contracts;

use Illuminate\Http\Request;

interface RepositoryInterface
{
    public function index();
    public function create();
    public function store(Request $request);
    public function show(int $id);
    public function edit(int $id);
    public function update(Request $request, int $id);
    public function destroy(int $id);
}