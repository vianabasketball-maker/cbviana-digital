// CBV Beta Access — WPCode PHP Snippet
// Regista role beta_tester e endpoint de verificação de acesso

// ─── REGISTAR ROLE BETA_TESTER ────────────────────────────────────────────────
add_action('init', function() {
    if (!get_role('beta_tester')) {
        add_role('beta_tester', 'Beta Tester', [
            'read' => true,
        ]);
    }
});

// ─── ENDPOINT: VERIFICAR ACESSO ───────────────────────────────────────────────
add_action('rest_api_init', function() {
    register_rest_route('cbv/v1', '/apostas/acesso', [
        'methods'             => 'GET',
        'permission_callback' => '__return_true',
        'callback'            => function() {
            if (!is_user_logged_in()) {
                return rest_ensure_response([
                    'acesso' => false,
                    'motivo' => 'not_logged_in',
                ]);
            }
            $user  = wp_get_current_user();
            $roles = (array) $user->roles;

            // Admin e beta_tester têm acesso
            $tem_acesso = in_array('administrator', $roles)
                       || in_array('beta_tester', $roles);

            return rest_ensure_response([
                'acesso' => $tem_acesso,
                'role'   => $roles,
            ]);
        },
    ]);
});
