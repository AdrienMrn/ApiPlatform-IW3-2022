<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    protected function supports($attribute, $subject): bool
    {
        $supportsAttribute = in_array($attribute, ['DIRECTOR_NEW', 'DIRECTOR_OLD']);
        $supportsSubject = $subject instanceof User;

        return $supportsAttribute && $supportsSubject;
    }

    /**
     * @param string $attribute
     * @param User $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        if (!in_array('ROLE_DIRECTOR', $token->getUser()->getRoles())) return false;

        switch ($attribute) {
            case 'DIRECTOR_NEW':
                return $this->accessNewDirector($subject);
                break;
            case 'DIRECTOR_OLD':
                return $this->accessOldDirector($subject);
        }

        return false;
    }

    private function accessNewDirector(User $subject) {
        return (new \DateTimeImmutable('-1 month')) < $subject->getCreatedAt();
    }

    private function accessOldDirector(User $subject) {
        return new \DateTimeImmutable('-1 month') > $subject->getCreatedAt();
    }
}
