import { inContainer } from 'in-container';
import { exec as _ } from 'node:child_process';
import { promisify } from 'node:util';

const exec = promisify(_);

if (!(await inContainer())) {
    console.log(
        '\x1b[1;31m[ERROR]\x1b[0m You need to run this script from a container!',
    );
    console.log('\x1b[1;34m[INFO]\x1b[0m Run the "make" command instead!');
    process.exit(1);
}

exec('node esbuild.config.js');

exec(
    'pnpm tailwindcss -i ./src/styles/global.css -o ./assets/global.min.css -m -w always',
);

console.log('\x1b[1;32m[SUCCESS]\x1b[0m Running...!');
