import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import CharacterCount from '@tiptap/extension-character-count'
import Placeholder from '@tiptap/extension-placeholder'
import Underline from '@tiptap/extension-underline'
import TextAlign from '@tiptap/extension-text-align'
import Highlight from '@tiptap/extension-highlight'
import Image from '@tiptap/extension-image'
import Strike from '@tiptap/extension-strike'
import Mention from '@tiptap/extension-mention'
import BubbleMenu from '@tiptap/extension-bubble-menu'
import axios from 'axios'

document.addEventListener('DOMContentLoaded', () => {
    const editorElement = document.getElementById('tiptap-editor')
    const bubbleMenuElement = document.getElementById('bubble-menu')
    
    if (editorElement) {
        const initialContent = editorElement.innerHTML;
        editorElement.innerHTML = '';

        const editor = new Editor({
            element: editorElement,
            extensions: [
                StarterKit.configure({
                    heading: { levels: [1, 2, 3] },
                }),
                Placeholder.configure({
                    placeholder: 'Write your epic story here...',
                }),
                CharacterCount.configure({ limit: null }),
                Underline,
                Strike,
                Highlight.configure({ multicolor: true }),
                Image.configure({
                    allowBase64: true,
                    HTMLAttributes: {
                        class: 'rounded-xl shadow-lg max-w-full my-8',
                    },
                }),
                TextAlign.configure({ types: ['heading', 'paragraph'] }),
                Mention.configure({
                    HTMLAttributes: {
                        class: 'character-mention',
                    },
                }),
                BubbleMenu.configure({
                    element: bubbleMenuElement,
                    tippyOptions: { duration: 100 },
                }),
            ],
            content: initialContent,
            onUpdate: ({ editor }) => {
                const words = editor.storage.characterCount.words()
                const characters = editor.storage.characterCount.characters()
                
                const event = new CustomEvent('editorUpdate', {
                    detail: { words, characters, content: editor.getHTML() }
                });
                document.dispatchEvent(event);

                clearTimeout(window.saveTimeout);
                window.saveTimeout = setTimeout(() => {
                    saveChapter(editor);
                }, 2000);
            },
        })

        window.tiptapEditor = editor;
        
        async function saveChapter(editorInstance) {
            const chapterId = document.body.dataset.chapterId;
            if (!chapterId) return;

            const titleInput = document.getElementById('chapter-title-input');
            const subtitleInput = document.getElementById('chapter-subtitle-input');

            document.dispatchEvent(new CustomEvent('saveStateChange', { detail: 'saving' }));

            try {
                await axios.post(`/studio/autosave/${chapterId}`, {
                    title: titleInput ? titleInput.value : null,
                    subtitle: subtitleInput ? subtitleInput.value : null,
                    content: editorInstance.getHTML(),
                    words_count: editorInstance.storage.characterCount.words(),
                    characters_count: editorInstance.storage.characterCount.characters(),
                });
                document.dispatchEvent(new CustomEvent('saveStateChange', { detail: 'saved' }));
            } catch (error) {
                console.error('Auto-save failed:', error);
                document.dispatchEvent(new CustomEvent('saveStateChange', { detail: 'error' }));
            }
        }

        setTimeout(() => {
            const alpineComponent = document.querySelector('[x-data="studioManager()"]');
            if (alpineComponent) {
                // If it's a standard Alpine component (v3)
                if (alpineComponent.__x) {
                    alpineComponent.__x.$data.editor = editor;
                } else {
                    // Try to find it via Alpine global if needed, but dispatching is safer
                    window.dispatchEvent(new CustomEvent('editorReady', { detail: { editor } }));
                }
                
                const words = editor.storage.characterCount.words()
                const characters = editor.storage.characterCount.characters()
                document.dispatchEvent(new CustomEvent('editorUpdate', { detail: { words, characters } }));
            }
        }, 100);
    }
})
