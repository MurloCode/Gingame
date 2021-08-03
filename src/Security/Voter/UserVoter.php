<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{

    const USER_EDIT = 'user_edit';

    protected function supports(string $attribute, $subject): bool
    {
         // $attribute ==> USER_EDIT
        // $subject ==> $user
        // dump($attribute, $subject);

        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        // Cette ligne retournera VRAI si les deux conditions
        // sont respectées : 
        // 
        return in_array($attribute, ['USER_EDIT', 'USER_VIEW'])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'USER_EDIT':
                if($user == $subject){
                    return true;
                }
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case 'POST_VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
