import { useEffect } from 'react'

export function useWaitFor(cb, deps, then) {
  useEffect(() => {
    let active = true
    load()
    return () => { active = false }

    async function load() {
      const res = await cb();
      if (!active) { return }
      then(res)
    }
  // eslint-disable-next-line react-hooks/exhaustive-deps
  }, deps)
}
