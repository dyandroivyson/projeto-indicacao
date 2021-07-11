<?php

use Illuminate\Database\Seeder;

class StatusIndicacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $situacoes = [
            [
                'id' => 1,
                'descricao' => 'INICIADA'
            ],
            [
                'id' => 2,
                'descricao' => 'EM PROCESSO'
            ],
            [
                'id' => 3,
                'descricao' => 'FINALIZADA'
            ]
        ];

        foreach ($situacoes as $situacao) {
            $status = \App\StatusIndicacao::where('descricao', '=', $situacao['descricao'])->first();

            if (!$status) {
                $situacao['created_at'] = date('Y-m-d H:i:s');
                $situacao['updated_at'] = date('Y-m-d H:i:s');

                \App\StatusIndicacao::create($situacao);
            }
        }
    }
}
