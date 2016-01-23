<?php

// Couple of sample commands and corresponding handlers

class AddUserCommand
{

}

class DeleteUserCommand
{

}

class AddUserHandler
{
    public function handle(AddUserCommand $command)
    {
        echo "Adding user\n";
    }
}

class DeleteUserHandler
{
    public function handle(DeleteUserCommand $command)
    {
        echo "Deleting user\n";
    }
}
