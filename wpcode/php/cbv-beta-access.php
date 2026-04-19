// CBV Beta Access — WPCode PHP Snippet
// v1.2 · 2026-04-19
// v1.0 — Regista role beta_tester e endpoint de verificação de acesso
// v1.1 — Tentativas de fix UM redirect
// v1.2 — Remove todos os hooks UM para beta_tester + herda caps subscriber

// ─── REGISTAR ROLE BETA_TESTER ────────────────────────────────────────────────
add_action('init', function() {
    if (!get_role('beta_tester')) {
        $subscriber = get_role('subscriber');
        $caps = $subscriber ? $subscriber->capabilities : ['read' => true];
        add_role('beta_tester', 'Beta Tester', $caps);
    }
});

// ─── FIX UM REDIRECT PARA BETA_TESTER ────────────────────────────────────────
add_action('template_redirect', function() {
    if (!is_user_logged_in()) return;
    $user = wp_get_current_user();
    if (!in_array('beta_tester', (array)$user->roles)) return;

    // Remove todos os hooks do UM no template_redirect
    global $wp_filter;
    if (!isset($wp_filter['template_redirect'])) return;
    foreach ($wp_filter['template_redirect']->callbacks as $priority => &$callbacks) {
        foreach ($callbacks as $key => $cb) {
            $fn = $cb['function'];
            if (is_array($fn) && is_object($fn[0])) {
                $class = get_class($fn[0]);
                if (strpos($class, 'UM_') === 0 || strpos($class, 'um_') === 0) {
                    unset($callbacks[$key]);
                }
            }
        }
    }
}, 1);

// Força UM a tratar beta_tester como member
add_filter('um_user_role', function($role, $user_id) {
    $user = get_userdata($user_id);
    if ($user && in_array('beta_tester', (array)$user->roles)) {
        return 'member';
    }
    return $role;
}, 10, 2);

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
            $tem_acesso = in_array('administrator', $roles)
                       || in_array('beta_tester', $roles);
            return rest_ensure_response([
                'acesso' => $tem_acesso,
                'role'   => $roles,
            ]);
        },
    ]);
});
