import isDocker from 'is-docker';
import { exec } from 'node:child_process';

if (!isDocker()) {
    console.log(
        '\x1b[1;31m[ERROR]\x1b[0m You need to run this script from docker!',
    );
    console.log('\x1b[1;34m[INFO]\x1b[0m Use start package.json script!');
    process.exit(1);
}

exec(
    'pnpm tailwindcss -i ./src/styles/global.css -o ./assets/global.min.css -m -w always',
);

exec('node esbuild.config.js');

console.log('\x1b[1;32m[SUCCESS]\x1b[0m Running...!');
