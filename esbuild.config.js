import { context } from 'esbuild';
import copy from 'esbuild-plugin-copy-watch';
import { mkdir } from 'node:fs/promises';
import { glob } from 'tinyglobby';

const files = await glob('assets/*.{js,css}', {
    ignore: 'assets/*.min.{js,css}',
});

const other = async () =>
    await glob('assets/*', { ignore: ['assets/*.ts', ...files] });

await mkdir('public', { recursive: true });

const ctx = await context({
    entryPoints: files,
    outdir: 'public',
    outExtension: {
        '.js': '.min.js',
        '.css': '.min.css',
    },
    minify: true,
    allowOverwrite: true,
    plugins: [
        copy({
            paths: (await other()).map((o) => ({
                from: o,
                to: '.',
            })),
        }),
    ],
});
await ctx.watch();
