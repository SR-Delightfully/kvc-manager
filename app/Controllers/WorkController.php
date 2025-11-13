<?php 
declare(strict_types=1); 

namespace App\Controllers; 

use DI\Container; 
use Psr\Http\Message\ResponseInterface as Response; 
use Psr\Http\Message\ServerRequestInterface as Request; 
use App\Domain\Models\PalletModel; 
use App\Domain\Models\ProductModel; 
use App\Helpers\UserContext;

class WorkController extends BaseController { 
    public function __construct( Container $container, private PalletModel $palletModel) { 
        parent::__construct($container); 
        } 

        public function index(Request $request, Response $response, array $args): Response { 
            $user = UserContext::getCurrentUser(); 
            $logs = $user->isAdmin() ? 
                $this->palletModel->getAll() : 
                $this->palletModel->getByUser($user->id); 
            $data = [ 
                'page_title' => 'Welcome to KVC Manager', 
                'contentView' => APP_VIEWS_PATH . '/pages/workView.php',
                'isSideBarShown' => true, 
                'isAdmin' => $user->isAdmin(), 
                'logs' => $logs, 
                'data' => [ 
                    'title' => 'Work', 
                    'message' => 'Work Page', 
                ] 
            ]; 
            return $this->render($response, 'common/layout.php', $data); 
        } 

        public function edit(Request $request, Response $response, array $args): Response { 
            $user = UserContext::getCurrentUser(); 
            $log = $this->palletModel->find($args['id']); 

            if (!$user->isAdmin() && $log->user_id !== $user->id) { 
                return $response->withStatus(403, 'Forbidden'); 
            } 
            
            return $this->render($response, 'admin/orderShowView.php', [ 'log' => $log, 'isAdmin' => $user->isAdmin() ]);
        }
            
        public function update(Request $request, Response $response, array $args): Response { 
            $user = UserContext::getCurrentUser(); 
            $id = $args['id'] ?? null; 
            $data = (array)$request->getParsedBody(); 

            if ($id) { 
                $log = $this->palletModel->find($id);
                
                if (!$user->isAdmin() && $log->user_id !== $user->id) { 
                    return $response->withStatus(403, 'Forbidden'); 
                } 
                
                $this->palletModel->update($id, $data);
            } else { 
                $data['user_id'] = $user->id; 
                $this->palletModel->create($data); 
            } 
            return $response->withHeader('Location', '/work')->withStatus(302); 
        } 
            
        public function store(Request $request, Response $response, array $args): Response { 
            $user = UserContext::getCurrentUser(); 
            $data = [ 
                'log' => null, 
                'isAdmin' => $user->isAdmin() 
            ]; 
            return $this->render($response, 'worklog/form.php', $data); 
        } 
        
        public function delete(Request $request, Response $response, array $args): Response { 
            $user = UserContext::getCurrentUser(); 
            
            if (!$user->isAdmin()) { 
                return $response->withStatus(403, 'Forbidden'); 
            } 
            
            $id = $args['id']; $this->palletModel->delete($id); 
            
            return $response->withHeader('Location', '/work')->withStatus(302); 
        } 
        
        public function error(Request $request, Response $response, array $args): Response { 
            return $this->render($response, 'errorView.php'); 
        } 
    } 
?>