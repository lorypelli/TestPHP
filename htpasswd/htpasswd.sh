#!/usr/bin/env bash

handle_sigint() {
    printf "\n"
    exit 1
}

start_spinner() {
    while true; do
        echo -n "."
        sleep 1
    done
}

trap handle_sigint SIGINT

FILE_PATH="/etc/nginx/.htpasswd"

if [ -s "$FILE_PATH" ]; then
    echo -e "\x1b[1;31m[ERROR]\x1b[0m Please remove the .htpasswd file before running this script!"
    exit 1
fi

echo -en "\x1b[1;34m[INFO]\x1b[0m Provide Username: "
read -r username
echo -en "\x1b[1;34m[INFO]\x1b[0m Provide Password: "
read -rs password
printf "\n"
echo -en "\x1b[1;34m[INFO]\x1b[0m Provide Password: (again) "
read -rs verification_password
printf "\n"

if [[ -z "$username" || -z "$password" || -z "$verification_password" ]]; then
    echo -e "\x1b[1;31m[ERROR]\x1b[0m Values cannot be empty!"
    exit 1
fi

if [[ "$password" != "$verification_password" ]]; then
    echo -e "\x1b[1;31m[ERROR]\x1b[0m Passwords do not match!"
    exit 1
fi

touch "$FILE_PATH"

start_spinner &

PID="$!"

htpasswd -bBC 16 "$FILE_PATH" "$username" "$password" &> /dev/null

EXIT="$?"

kill "$PID"
wait "$PID"

printf "\n"

if [[ "$EXIT" -ne 0 ]]; then
    echo -e "\x1b[1;31m[ERROR]\x1b[0m Failed adding password for user $username!"
    exit 1
else
    echo -e "\x1b[1;32m[SUCCESS]\x1b[0m Added password for user $username!"
fi
