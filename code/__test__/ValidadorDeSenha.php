<?php

class ValidadorDeSenha
{
    /***
     * Valida uma senha com base em múltiplos critérios usando expressão regular.
     *
     * Critérios:
     * - Pelo menos uma letra maiúscula.
     * - Pelo menos uma letra minúscula.
     * - Pelo menos um número.
     * - Pelo menos um caractere especial.
     * - Mínimo de 6 caracteres de comprimento.
     *
     * @param string $senha A senha a ser validada.
     * @return bool Retorna true se a senha for válida, false caso contrário.
     */
    public function validar(string $senha): bool
    {
        // A expressão regular para validar a senha
        $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{6,}$/';

        // preg_match retorna 1 se encontrar o padrão, 0 se não, e false em caso de erro.
        // Convertemos para booleano para um retorno claro (true/false).
        return preg_match($regex, $senha) === 1;
    }
}

// --- Exemplo de como usar a classe ---

$validador = new ValidadorDeSenha();

$senhasParaTestar = [
    'senha123',         // Falha (sem maiúscula, sem especial)
    'Senha123',         // Falha (sem especial)
    'SENHA123#',        // Falha (sem minúscula)
    'Senhafraca#',      // Falha (sem número)
    'S#123',            // Falha (muito curta)
    'SenhaForte123#',   // Válida
    'Abc@123',          // Válida
    'XyZ-987!',         // Válida
];

foreach ($senhasParaTestar as $senha) {
    if ($validador->validar($senha)) {
        echo "A senha '{$senha}' é VÁLIDA.\n";
    } else {
        echo "A senha '{$senha}' é INVÁLIDA.\n";
    }
}